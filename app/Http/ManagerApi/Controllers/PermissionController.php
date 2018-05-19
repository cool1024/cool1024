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



class PermissionController extends Controller
{
    public function getAllPermissionWithGroup()
    {
        $groups = SystemPermissionGroup::all();
        $permissions = SystemPermission::all();
        return $this->api->getMessage([
            'groups' => $groups,
            'permissions' => $permissions,
        ]);
    }

    public function insertPermissionGroup()
    {
        $required = ['permission_group_name:max:45'];
        $params = $this->api->camelCaseParams($required);
        $group = SystemPermissionGroup::create($params);
        return $this->api->getMessage($group);
    }

    public function insertPermission()
    {
        $required = [
            'permission_group_id:integer',
            'permission_name:max:45',
            'permission_key:max:45'
        ];
        $params = $this->api->camelCaseParams($required);
        SystemPermissionGroup::findOrFail($params['permission_group_id']);
        $permission = SystemPermission::create($params);
        return $this->api->success($permission);
    }

    public function deletePermissionGroup()
    {
        $required = ['permission_group_id:integer'];
        $params = $this->api->camelCaseParams($required);
        $result = SystemPermissionGroup::findOrFail($params['permission_group_id'])->delete();
        SystemPermission::where($params)->delete();
        return $this->api->deleteMessage($result);
    }

    public function deletePermission()
    {
        $required = ['permission_id:integer'];
        $params = $this->api->camelCaseParams($required);
        $result = SystemPermission::findOrFail($params['permission_id'])->delete();
        return $this->api->deleteMessage($result);
    }

    public function updatePermissionGroup()
    {
        $required = [
            'id:integer',
            'permission_group_name:max:45',
        ];
        $params = $this->api->camelCaseParams($required);
        $result = SystemPermissionGroup::findOrFail($params['id'])
            ->fill(['permission_group_name' => $params['permission_group_name']])
            ->save();
        return $this->api->updateMessage($result);
    }

    public function updatePermission()
    {
        $required = [
            'id:integer',
            'permission_group_id:integer',
            'permission_name:max:45',
            'permission_key:max:45'
        ];
        $params = $this->api->camelCaseParams($required);
        SystemPermissionGroup::findOrFail($params['permission_group_id']);
        $result = SystemPermission::findOrFail($params['id'])
            ->fill($params)
            ->save();
        return $this->api->updateMessage($result);
    }
}
