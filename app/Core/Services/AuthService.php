<?php

namespace App\Core\Services;

use App\Core\Contracts\AuthContract;
use App\Core\Contracts\UserContract;
use App\Core\Contracts\TokenContract;


class AuthService implements AuthContract
{

    public $userService;
    public $tokenService;

    /**
     * 导入用户相关服务
     * 
     * @param UserContract 用户服务 
     */
    public function initUserService(UserContract $userService)
    {
        $this->userService = $userService;
    }

    /**
     * 导入用令牌相关服务
     * 
     * @param TokenContract 令牌服务
     */
    public function initTokenService(TokenContract $tokenService)
    {
        $this->tokenService = $tokenService;
    }
}