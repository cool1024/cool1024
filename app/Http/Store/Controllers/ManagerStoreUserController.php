<?php

/**
 * 会员管理控制器
 * 
 * @file   ManagerStoreUserController.php
 * @author xiaojian
 * @date   2018-04-27
 */
namespace App\Http\Store\Controllers;

use App\Http\Store\Models\StoreUser;

class ManagerStoreUserController extends Controller
{

    /**
     * 用户列表-分页
     */
    public function searchUser()
    {
        $required = [
            'limit:integer',
            'offset:integer',
        ];

        $expected = [
            'start:date',
            'end:date',
            'nick:max:45',
            'mobile:max:45',
        ];

        $params = $this->api->camelCaseParams($required, $expected);

        $search_params = [
            ['whereDate', 'created_at', '>=', '$start'],
            ['whereDate', 'created_at', '<=', '$end'],
            ['where', 'nick', 'like', '$nick'],
            ['where', 'mobile', 'like', '$mobile'],
        ];

        $search_formats = [
            'nick' => '%$nick%',
            'mobile' => '%$mobile%',
        ];

        $search_result = with(new StoreUser)->search($params, $search_params, $search_formats);
        return $this->api->searchMessage($search_result);
    }

    /**
     * 获取用户详情
     */
    public function getUser()
    {

        $required = [
            'user_id:integer'
        ];

        $params = $this->api->camelCaseParams($required);

        return $this->api->getMessage(StoreUser::findOrFail($params['user_id']));
    }

    /**
     * 更新用户详情
     */
    public function updateUser()
    {

        $required = [
            'id:integer'
        ];

        $expected = [
            'mobile:max:45',
            'vip_level:integer',
        ];

        $params = $this->api->camelCaseParams($required, $expected);

        return $this->api->updateMessage(StoreUser::findOrFail($params['id'])->update($params));
    }

    /**
     * 获取用户等级下拉
     */
    public function getUserLevelOptions()
    {
        $options = [
            ['value' => 0, 'text' => 'Lv.1'],
            ['value' => 1, 'text' => 'Lv.2'],
            ['value' => 2, 'text' => 'Lv.3'],
            ['value' => 3, 'text' => 'Lv.4'],
            ['value' => 4, 'text' => 'Lv.5'],
        ];

        return $this->api->getMessage($options);
    }
}
