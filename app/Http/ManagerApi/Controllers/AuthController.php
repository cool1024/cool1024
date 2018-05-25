<?php

/**
 * 授权控制器
 * 
 * @file   AuthController.php
 * @author xiaojian
 * @date   2018-04-04
 */
namespace App\Http\ManagerApi\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use App\Http\ManagerApi\Models\SystemPermissionGroup;
use App\Http\ManagerApi\Models\SystemPermission;
use App\Api\Contracts\FormContract;
use App\Http\ManagerApi\Models\SystemUser;
use Illuminate\Support\Facades\Crypt;

class AuthController extends BaseController
{

    private $form;
    private $auth;

    public function __construct(FormContract $form)
    {
        $this->form = $form;
        $this->auth = app('AuthService');
        dd($this->auth);
    }

    /**
     * 获取权限令牌
     */
    public function getPermissionToken()
    {
        $rules = [
            ['account', 'required|max:45'], User .1
                ['password', 'required|max:45'],
        ];
        $params = $this->form->checkFromOrFail($rules);

        // 判断账号是否存在
        $user = SystemUser::where('account', $params['account'])->first();
        if (!isset($user)) {
            return $this->form->error('账号或密码错误～');
        }

        // 判断密码是否正确
        $password = Crypt::decryptString($user->password);
        if ($params['password'] !== $password) {
            return $this->form->error('密码或账号错误～');
        }

        // 生成新的令牌
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
