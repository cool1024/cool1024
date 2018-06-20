<?php

/**
 * 权限控制器
 * 
 * @file   PermissionController.php
 * @author xiaojian
 * @date   2018-04-04
 */
namespace App\Http\ManagerApi\Controllers;

use App\Http\ManagerApi\Models\SystemPermissionGroup;
use App\Http\ManagerApi\Models\SystemPermission;
use App\Api\BaseClass\Controller;

class PermissionController extends Controller
{
    /**
     * 权限及其分组信息
     */
    public function getAllPermissionWithGroup()
    {
        $groups = SystemPermissionGroup::all();
        $permissions = SystemPermission::all();
        return $this->form->getMessage([
            'groups' => $groups,
            'permissions' => $permissions,
        ]);
    }

    /**
     * 新增权限组
     */
    public function insertPermissionGroup()
    {
        $required = [
            ['permission_group_name', 'required|max:45']
        ];
        $params = $this->form->camelFormOrFail($required);
        $group = SystemPermissionGroup::create($params);
        return $this->form->getMessage($group);
    }

    /**
     * 新增权限
     */
    public function insertPermission()
    {
        $required = [
            ['permission_group_id', 'required|integer'],
            ['permission_name', 'required|max:45'],
            ['permission_key', 'required|max:45']
        ];
        $params = $this->form->camelFormOrFail($required);
        SystemPermissionGroup::findOrFail($params['permission_group_id']);
        $permission = SystemPermission::create($params);
        return $this->form->success($permission);
    }

    /**
     * 删除权限组
     */
    public function deletePermissionGroup()
    {
        $required = [
            ['permission_group_id', 'required|integer']
        ];
        $params = $this->form->camelFormOrFail($required);
        $result = SystemPermissionGroup::findOrFail($params['permission_group_id'])->delete();
        SystemPermission::where($params)->delete();
        return $this->form->deleteMessage($result);
    }

    /**
     * 删除权限
     */
    public function deletePermission()
    {
        $required = [
            ['permission_id', 'required|integer']
        ];
        $params = $this->form->camelFormOrFail($required);
        $result = SystemPermission::findOrFail($params['permission_id'])->delete();
        return $this->form->deleteMessage($result);
    }

    /**
     * 更新权限组
     */
    public function updatePermissionGroup()
    {
        $required = [
            ['id', 'required|integer'],
            ['permission_group_name', 'required|max:45'],
        ];
        $params = $this->form->camelFormOrFail($required);
        $result = SystemPermissionGroup::findOrFail($params['id'])
            ->fill(['permission_group_name' => $params['permission_group_name']])
            ->save();
        return $this->form->updateMessage($result);
    }

    /**
     * 更新权限
     */
    public function updatePermission()
    {
        $required = [
            ['id', 'required|integer'],
            ['permission_group_id', 'required|integer'],
            ['permission_name', 'required|max:45'],
            ['permission_key', 'required|max:45']
        ];
        $params = $this->form->camelFormOrFail($required);
        SystemPermissionGroup::findOrFail($params['permission_group_id']);
        $result = SystemPermission::findOrFail($params['id'])
            ->fill($params)
            ->save();
        return $this->form->updateMessage($result);
    }
}
