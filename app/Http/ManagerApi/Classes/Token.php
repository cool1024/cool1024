<?php

/**
 * 令牌类，包含了权限令牌的相关方法
 * @file   Token.php
 * @author xiaojian
 * @date   2018-04-04
 */

namespace App\Http\ManagerApi\Classes;

use App\Http\ManagerApi\Models\SystemToken;
use App\Core\Contracts\TokenContract;
use Carbon\Carbon;

class Token implements TokenContract
{

    // 当前令牌实例
    private $token;

    // 数据库令牌字段名称
    private $tokenField = 'token';

    // 令牌过期时间0为永不过期
    private $tokenLostTime = 15;

    /**
     * 注入令牌
     * @param any $tokenParams 令牌校验需要的参数
     */
    public function init($tokenParams = [])
    {
        $this->token = SystemToken::where($tokenParams)->first();
    }

    /**
     * 更新令牌
     * @param array $appenParams 附加参数，如果需要在插入新令牌的时候添加额外的参数
     * @return string|array 新令牌数据
     */
    public function updateToken($appendParams = [])
    {
        $appendParams[$this->tokenField] = base64_encode(sha1(uniqid()) . md5(time()));
        $this->token = isset($this->token) ? $this->token : new SystemToken();
        $this->token->fill($appendParams)->save();
        return $this->token;
    }

    /**
     * 令牌校验
     * @param array $tokenParams 令牌校验需要的参数
     * @return bool 校验结果
     */
    public function checkToken($tokenParams = [])
    {

        // 令牌不存在
        if (!isset($this->token)) {
            return false;
        }

        // 令牌是否匹配
        $fields = $this->token->toArray();
        foreach ($tokenParams as $field => $value) {
            if ($fields[$field] != $value) {
                return false;
            }
        }
        // 令牌是否过期
        if ($this->tokenLostTime > 0) {
            $lost = $this->token->updated_at->addDay($this->tokenLostTime);
            $now = Carbon::now();
            // 失效时间大于或等于现在时间，那么这个令牌还有效
            return $lost->greaterThanOrEqualTo($now);
        }

        return true;
    }

    /**
     * 移除当前令牌（如果存在的话）
     * @return bool|null
     */
    public function removeToken()
    {
        return isset($this->token) ? $this->token->delete() : false;
    }

    /**
     * 获取当前令牌
     * @return Model 令牌实例
     */
    public function getToken()
    {
        return $this->token;
    }
}