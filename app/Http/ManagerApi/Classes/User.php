<?php

/**
 * 用户账户类，提供了用于获取，操作当前用户的相关方法
 * @file   User.php
 * @author xiaojian
 * @date   2018-04-04
 */

namespace App\Http\ManagerApi\Classes;

use App\Core\Contracts\UserContract;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\ManagerApi\Models\SystemUser;
use App\Http\ManagerApi\Models\SystemRole;
use App\Http\ManagerApi\Models\SystemPermission;

class User implements UserContract
{

    private $userModel;

    private $roleModel;

    /**
     * 注入用户
     * @param mixed $userParams 用户模型或其他需要的参数
     */
    public function init($userParams)
    {
        if ($userParams instanceof Model) {
            $this->userModel = $userParams;
        } else if (gettype($userParams) === 'integer') {
            $this->userModel = SystemUser::findOrFail($userParams);
        } else {
            $this->userModel = SystemUser::where($userParams)->first();
            if (!isset($this->userModel)) {
                throw new ModelNotFoundException('不存在的用户');
            }
        }
    }

    /**
     * 获取用户的ORM实例
     * 
     * @return Model
     */
    public function user()
    {
        return $this->userModel;
    }

    /**
     * 获取用户的详细信息
     * 
     * @return array
     */
    public function detail()
    {
        if (!isset($this->roleModel)) {
            $this->roleModel = SystemRole::findOrFail($this->userModel->role_id);
            $this->userModel->role = $this->roleModel;
        }
        return $this->userModel;
    }

    /**
     * 获取用户的所有权限
     * 
     * @return array
     */
    public function permissions()
    {
        $this->detail();
        $permissions = json_decode($this->roleModel->permission_ids, true);
        if (!isset($permissions)) {
            $permissions = [];
        }
        return $permissions;
    }

    /**
     * 判断用户有没有某个权限
     * @param mixed $permissionParams
     * @return bool
     */
    public function hasPermission($permissionParams)
    {
        $permissions = $this->permissions();
        $permission = SystemPermission::where('permission_key', $permissionParams)->first(['id']);
        if (!isset($permission)) {
            return abort(200, '找不到符合关键词的权限');
        }
        return in_array($permission['id'], $permissions);
    }
}