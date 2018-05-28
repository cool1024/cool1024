<?php

/**
 * 角色控制器
 * 
 * @file   RoleController.php
 * @author xiaojian
 * @date   2018-04-04
 */
namespace App\Http\ManagerApi\Controllers;

use App\Api\BaseClass\Controller;
use App\Http\ManagerApi\Models\SystemRole;

class RoleController extends Controller
{
    /**
     * 获取所有角色
     */
    public function getAllRole()
    {
        $roles = SystemRole::all();
        return $this->form->getMessage($roles);
    }

    /**
     * 添加新角色
     */
    public function insertRole()
    {
        $rules = [
            ['role_parent_id', 'required|integer'],
            ['role_name', 'required|max:45'],
            ['permission_ids', 'array'],
        ];
        $params = $this->form->camelFormOrFail($rules);

        $params['permission_ids'] = json_encode($params['permission_ids']);
        $role = SystemRole::create($params);
        return $this->form->createMessage($role);
    }

    /**
     * 更新角色
     */
    public function updateRole()
    {
        $rules = [
            ['id', 'required|integer'],
            ['role_name', 'required|max:45'],
            ['permission_ids', 'array'],
        ];
        $params = $this->form->camelFormOrFail($rules);
        $result = SystemRole::findOrFail($params['id'])
            ->fill([
                'role_name' => $params['role_name'],
                'permission_ids' => json_encode($params['permission_ids']),
            ])->save();
        return $this->form->saveMessage($result);
    }

    /**
     * 删除角色
     */
    public function deleteRole()
    {
        $rules = [
            ['role_id', 'required|integer']
        ];
        $params = $this->form->camelFormOrFail($rules);

        $result = SystemRole::findOrFail($params['role_id'])->delete();
        return $this->form->deleteMessage($result);
    }
}
