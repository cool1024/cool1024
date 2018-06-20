<?php

/**
 * 授权控制器
 * 
 * @file   AuthController.php
 * @author xiaojian
 * @date   2018-04-04
 */
namespace App\Http\ManagerApi\Controllers;

use App\Api\BaseClass\Controller;
use App\Http\ManagerApi\Models\SystemUser;
use Illuminate\Support\Facades\Crypt;
use App\Http\ManagerApi\Classes\User;
use App\Http\ManagerApi\Classes\Token;

class AuthController extends Controller
{

    private $userService;
    private $tokenService;

    public function __construct()
    {
        parent::__construct();
        $this->userService = new User();
        $this->tokenService = new Token();
    }

    /**
     * 获取授权令牌
     * 
     * @var string account 账号
     * @var string password 密码
     */
    public function getAuthToken()
    {
        $rules = [
            ['account', 'required|max:45'],
            ['password', 'required|max:45'],
        ];
        $params = $this->form->checkFormOrFail($rules);

        // 判断账号是否存在
        $user = SystemUser::where('account', $params['account'])->first();
        if (!isset($user)) {
            return $this->form->error('账号或密码错误～');
        }

        // 判断账号是否可用
        if ($user->is_active < 1) {
            return $this->form->error('该账号暂不可用～');
        }

        // 判断密码是否正确
        $password = Crypt::decryptString($user->password);
        if ($params['password'] !== $password) {
            return $this->form->error('密码或账号错误～');
        }

        // 注入令牌
        $this->tokenService->init([
            'uid' => $user->id,
            'platform' => 'managerapi',
        ]);

        // 获取并更新令牌
        $token = $this->tokenService->updateToken([
            'uid' => $user->id,
            'platform' => 'managerapi',
        ]);

        return $this->form->getMessage($token);
    }

    /**
     * 用户注册--这个是开发测试接口，上线必须关闭
     */
    public function signup()
    {
        $rules = [
            ['account', 'required|max:45'],
            ['password', 'required|max:45'],
        ];
        $params = $this->form->checkFormOrFail($rules);

        // 避免重复注册，这里不能完全避免重复注册
        $user = SystemUser::where('account', '=', $params['account'])->first();
        if (isset($user)) {
            return $this->form->error('账号已经被注册');
        }
        $params = array_merge($params, [
            'is_active' => 1,
            'role_id' => 1,
            'password' => Crypt::encryptString($params['password']),
        ]);
        $result = SystemUser::create($params);
        return $this->form->createMessage($result);
    }

    /**
     * 移除授权令牌
     */
    public function removeAuthToken()
    {
        $rules = [
            ['ng-params-one', 'required|integer|min:1'],
            ['ng-params-two', 'required|max:100'],
            ['ng-params-three', 'required|max:45'],
        ];
        $formats = [
            'ng-params-one' => 'id',
            'ng-params-two' => 'token',
            'ng-params-three' => 'platform',
        ];
        $params = $this->form->checkFormOrFail($rules, $formats);

        // 注入令牌
        $this->tokenService->init($params);

        // 销毁令牌
        $result = $this->tokenService->removeToken();

        return $result ? $this->form->success() : $this->form->error('令牌错误或已经销毁');
    }

    /**
     * 校验权限令牌
     */
    public function checkAuthToken()
    {
        $rules = [
            ['ng-params-one', 'required|integer|min:1'],
            ['ng-params-two', 'required|max:100'],
            ['ng-params-three', 'required|max:45'],
        ];
        $formats = [
            'ng-params-one' => 'id',
            'ng-params-two' => 'token',
            'ng-params-three' => 'platform',
        ];
        $params = $this->form->checkFormOrFail($rules, $formats);

        // 注入令牌
        $this->tokenService->init($params);

        // 校验令牌
        $result = $this->tokenService->checkToken();
        if ($result === false) {
            return $this->form->error('令牌错误或已经失效');
        }

        // 获取用户详情
        $this->userService->init($this->tokenService->getToken()->uid);
        $detail = $this->userService->detail();

        return $this->form->getMessage($detail);
    }
}
