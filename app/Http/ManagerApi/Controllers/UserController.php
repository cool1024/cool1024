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
use App\Sdk\OssSdk;

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

    /**
     * 头像上传授权
     */
    public function ossUpload()
    {
        // 示例化OssSdk
        $oss = new OssSdk('LTAIJUKgjPNJtHW3', '7R0o8odjGB8eKZm3rrwTC8m9sjYxFh', 'https://hello1024.oss-cn-beijing.aliyuncs.com');
        // 生成文件保存地址
        $file_path = 'upload/goods/' . date('Ymdhis') . uniqid(md5(microtime(true)), true);
        // 5000k设置
        return $this->form->getMessage($oss->getAccessDatas(1024 * 5000, 10, $file_path));
    }
}
