<?php

/**
 * 系统权限模型
 * @author xiaojian
 * @file SystemPermission.php
 * @date 2018-5-29
 */

namespace App\Http\ManagerApi\Models;

use Illuminate\Database\Eloquent\Model;

class SystemPermission extends Model
{
    protected $table = 'system_permission';

    protected $guarded = [];
}
