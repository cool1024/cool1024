<?php

namespace App\Core\Contracts;

interface TokenContract
{
    /**
     * 注入令牌
     * @param any $tokenParams 令牌校验需要的参数
     */
    public function init($tokenParams = []);

    /**
     * 更新令牌
     * 
     * @param array $appenParams 附加参数，如果需要在插入新令牌的时候添加额外的参数
     * @return string|array 新令牌数据
     */
    public function updateToken($appendParams = []);

    /**
     * 令牌校验
     * @param array $tokenParams 令牌校验需要的参数
     * @return bool 校验结果
     */
    public function checkToken($tokenParams = []);

    /**
     * 移除当前令牌（如果存在的话）
     * @return bool|null
     */
    public function removeToken();

    /**
     * 获取当前令牌
     * @return Model 令牌实例
     */
    public function getToken();
}
