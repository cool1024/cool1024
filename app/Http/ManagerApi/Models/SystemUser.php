<?php

/**
 * 系统账户模型
 * @author xiaojian
 * @file SystemUser.php
 * @date 2018-5-29
 */

namespace App\Http\ManagerApi\Models;

use Illuminate\Database\Eloquent\Model;
use App\Api\Traits\Orm\PageTrait;

class SystemUser extends Model
{
    use PageTrait;

    protected $table = 'system_user';

    protected $guarded = [];

    protected $hidden = ['password'];
}
