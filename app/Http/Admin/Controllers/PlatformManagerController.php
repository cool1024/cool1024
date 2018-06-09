<?php

/**
 * 平台管理控制器
 * 
 * @file   PlatformManagerController.php
 * @author xiaojian
 * @date   2018-04-04
 */
namespace App\Http\Admin\Controllers;

use Illuminate\Support\Facades\Crypt;
use App\Http\Admin\Models\AccessPlatformManager;
use App\Api\BaseClass\Controller;

class PlatformManagerController extends Controller
{

    /**
     * 新增平台管理员
     */
    public function insertPlatformManager()
    {
        $rules = [
            ['id', 'required|integer'],
            ['platform_manager_name', 'required|min:4|max:45'],
            ['platform_manager_account', 'required|min:4|max:30'],
            ['is_active', 'required|boolean'],
            ['password', 'required|min:4|max:20'],
            ['platform_manager_mobile', 'min:4|max:30'],
            ['platform_manager_email', 'email'],
        ];

        $params = $this->form->camelFormOrFail($rules);

        $compay = AccessPlatformManager::where('platform_manager_account', $params['platform_manager_account'])->first();

        if (isset($compay)) {
            return $this->form->error('账号已经被注册');
        }

        $params['password'] = Crypt::encryptString($params['password']);

        return $this->form->createMessage(AccessPlatformManager::create($params));
    }

    /**
     * 获取公司详情
     */
    public function getPlatformManager()
    {

        $rules = [
            ['platform_manager_id', 'required|integer']
        ];

        $params = $this->form->camelFormOrFail($rules);

        return $this->form->getMessage(AccessPlatformManager::findOrFail($params['platform_manager_id']));
    }

    /**
     * 更新平台管理员详情
     */
    public function updatePlatformManager()
    {

        $rules = [
            ['id', 'required|integer'],
            ['platform_manager_name', 'min:4|max:45'],
            ['is_active', 'boolean'],
            ['password', 'min:4|max:20'],
            ['platform_manager_mobile', 'min:4|max:30'],
            ['platform_manager_email', 'email'],
        ];

        $params = $this->form->camelFormOrFail($rules);

        if (count($params) <= 1) {
            return $this->form->error('lost update params');
        }

        if (isset($params['password'])) {
            $params['password'] = Crypt::encryptString($params['password']);
        }

        return $this->form->updateMessage(AccessPlatformManager::findOrFail($params['id'])->update($params));
    }

    /**
     * 删除平台管理员
     */
    public function deletePlatformManager()
    {

        $rules = [
            ['platform_manager_id', 'required|integer']
        ];

        $params = $this->form->camelFormOrFail($rules);
        return $this->form->deleteMessage(AccessPlatformManager::findOrFail($params['platform_manager_id'])->delete());
    }

    /**
     * 平台管理员列表-分页
     */
    public function searchPlatformManager()
    {
        $rules = [
            ['limit', 'required|integer'],
            ['offset', 'required|integer'],
            ['name', 'string|max:45'],
            ['account', 'string|max:30'],
        ];

        $wheres = [
            ['whereDate', 'created_at', '>=', '$start'],
            ['whereDate', 'created_at', '<=', '$end'],
            ['where', 'platform_manager_name', 'like', '$name'],
            ['where', 'platform_manager_account', 'like', '$account'],
        ];

        $formats = [
            'name' => '%$name%',
            'account' => '%$account%',
        ];

        $params = $this->form->camelFormOrFail($rules);
        $search_result = with(new AccessPlatformManager)->pagination($params, $wheres, $formats);
        return $this->form->getMessage($search_result);
    }
}
