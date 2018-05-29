<?php

/**
 * 系统令牌模型
 * @author xiaojian
 * @file SystemToken.php
 * @date 2018-5-29
 */

namespace App\Http\ManagerApi\Models;

use Illuminate\Database\Eloquent\Model;

class SystemToken extends Model
{
    protected $table = 'system_token';

    protected $guarded = [];
}
