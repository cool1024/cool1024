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
use App\Api\BaseClass\Controller;

class ManagerStoreUserController extends Controller
{

    /**
     * 用户列表-分页
     */
    public function searchUser()
    {
        $rules = [
            ['limit', 'required|integer'],
            ['offset', 'required|integer'],
            ['start', 'date'],
            ['end', 'date'],
            ['nick', 'max:45'],
            ['mobile', 'max:45'],
        ];

        $params = $this->form->camelFormOrFail($rules);

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

        $search_result = with(new StoreUser)->pagination($params, $search_params, $search_formats);
        return $this->form->getMessage($search_result);
    }

    /**
     * 获取用户详情
     */
    public function getUser()
    {

        $rules = [
            ['user_id', 'required|integer']
        ];

        $params = $this->form->camelFormOrFail($rules);

        return $this->form->getMessage(StoreUser::findOrFail($params['user_id']));
    }

    /**
     * 更新用户详情
     */
    public function updateUser()
    {

        $rules = [
            'id:integer'
        ];

        $expected = [
            'mobile:max:45',
            'vip_level:integer',
        ];

        $params = $this->form->camelFormOrFail($rules, $expected);

        return $this->form->updateMessage(StoreUser::findOrFail($params['id'])->update($params));
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

        return $this->form->getMessage($options);
    }
}
