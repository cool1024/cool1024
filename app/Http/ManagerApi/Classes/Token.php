<?php

namespace App\Http\ManagerApi\Classes;

use App\Api\Contracts\TokenContract;

class Token implements TokenContract
{

    private $token;

    /**
     * 注入令牌
     * @param Model $user 用户登入令牌记录模型
     */

    public function init($token)
    {
        $this->token = $token;
    }

    /**
     * 更新令牌
     * 
     * @return string|array 新令牌数据
     */
    public function updateToken()
    {
        // $newToken = sh
        if (isset($this->token)) {
            $this->token->token =
        }
    }

    /**
     * 令牌校验
     * @param any $token
     * @return bool 校验结果
     */
    public function checkToken($token)
    {

    }
}