<?php

/**
 * 系统账户模型
 * @author xiaojian
 * @file SystemUser.php
 * @date 2018-5-29
 */

namespace App\Http\ManagerApi\Models;

use Illuminate\Database\Eloquent\Model;

class SystemUser extends Model
{
    protected $table = 'system_user';

    protected $guarded = [];

    protected $hidden = ['password'];
}
