<?php

/**
 * 用户账户控制器
 * 
 * @file   UserController.php
 * @author xiaojian
 * @date   2018-04-04
 */
namespace App\Http\ManagerApi\Controllers;

use App\Api\BaseClass\Controller;
use App\Core\Contracts\AuthContract;
use Illuminate\Support\Facades\Crypt;

class UserController extends Controller
{

    private $userService;

    public function __construct(AuthContract $auth)
    {
        parent::__construct();
        $this->userService = $auth->userService;
    }

    /**
     * 获取用户信息
     */
    public function getUserInfo()
    {
        $userInfo = $this->userService->detail();
        return $this->form->getMessage($userInfo);
    }

    /**
     * 更新用户信息
     */
    public function updateUserInfo()
    {
        $rules = [
            ['avatar', 'max:200'],
            ['password', 'max:45'],
        ];
        $formats = [
            'password' => function ($key, &$value) {
                $value = Crypt::encryptString($value);
                return $key;
            }
        ];
        $params = $this->form->checkFormOrFail($rules, $formats, [1, '请至少修改一项']);
        $result = $this->userService->user()
            ->fill($params)
            ->save();
        return $this->form->saveMessage($result);
    }
}
