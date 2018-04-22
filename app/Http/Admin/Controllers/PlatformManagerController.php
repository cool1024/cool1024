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

class PlatformManagerController extends Controller
{

    /**
     * 新增平台管理员
     */
    public function insertPlatformManager()
    {

        $required = [
            'platform_manager_name:min:4|max:45',
            'platform_manager_account:min:4|max:30',
            'password:min:4|max:30',
            'is_active:boolean',
        ];

        $expected = [
            'platform_manager_mobile:min:4|max:30',
            'platform_manager_email:email',
        ];

        $params = $this->api->camelCaseParams($required, $expected);

        $compay = AccessPlatformManager::where('platform_manager_account', $params['platform_manager_account'])->first();

        if (isset($compay)) {
            return $this->api->error('账号已经被注册');
        }

        $params['password'] = Crypt::encryptString($params['password']);

        return $this->api->createMessage(AccessPlatformManager::create($params));
    }

    /**
     * 获取公司详情
     */
    public function getPlatformManager()
    {

        $required = [
            'platform_manager_id:integer'
        ];

        $params = $this->api->camelCaseParams($required);

        return $this->api->getMessage(AccessPlatformManager::findOrFail($params['platform_manager_id']));
    }

    /**
     * 更新平台管理员详情
     */
    public function updatePlatformManager()
    {

        $required = [
            'id:integer'
        ];

        $expected = [
            'is_active:boolean',
            'password:min:4|max:20',
            'platform_manager_mobile:min:4|max:30',
            'platform_manager_email:email',
        ];

        $params = $this->api->camelCaseParams($required, $expected);

        if (count($params) <= 1) {
            return $this->api->error('lost update params');
        }

        if (isset($params['password'])) {
            $params['password'] = Crypt::encryptString($params['password']);
        }

        return $this->api->updateMessage(AccessPlatformManager::findOrFail($params['id'])->update($params));
    }

    /**
     * 删除平台管理员
     */
    public function deletePlatformManager()
    {

        $required = [
            'platform_manager_id:integer'
        ];

        $params = $this->api->camelCaseParams($required);
        return $this->api->deleteMessage(AccessPlatformManager::findOrFail($params['platform_manager_id'])->delete());
    }

    /**
     * 平台管理员列表-分页
     */
    public function searchPlatformManager()
    {
        $required = [
            'limit:integer',
            'offset:integer',
        ];

        $params = $this->api->camelCaseParams($required);
        $search_result = with(new AccessPlatformManager)->search($params);
        return $this->api->searchMessage($search_result);
    }
}
