<?php

/**
 * 授权控制器
 * 
 * @file   AuthController.php
 * @author xiaojian
 * @date   2018-04-04
 */
namespace App\Http\ManagerApi\Controllers;

use App\Http\ManagerApi\Models\SystemPermissionGroup;
use App\Http\ManagerApi\Models\SystemPermission;



class AuthController extends Controller
{
    /**
     * 获取权限令牌
     */
    public function getPermissionToken()
    {
        $required = [
            'account:max:45',
        ];
    }

    /**
     * 移除权限令牌
     */
    public function removePermissionToken()
    {

    }

    /**
     * 校验权限令牌
     */
    public function checkPermissionToken()
    {

    }
}
