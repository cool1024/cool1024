<?php

namespace App\Core\Contracts;

use App\Core\Contracts\UserContract;
use App\Core\Contracts\TokenContract;

interface AuthContract
{
    /**
     * 导入用户相关服务
     * 
     * @param UserContract 用户服务
     */
    public function initUserService(UserContract $userService);

    /**
     * 导入用令牌相关服务
     * 
     * @param TokenContract 令牌服务
     */
    public function initTokenService(TokenContract $tokenService);
}
