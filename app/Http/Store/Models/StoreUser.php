<?php

/**
 * 商城用户模型
 * 
 * @file   StoreUser.php
 * @author xiaojian
 * @date   2018-04-27
 */
namespace App\Http\Store\Models;

use Illuminate\Database\Eloquent\Model;
use App\Api\Traits\Orm\PageTrait;

class StoreUser extends Model
{
    use PageTrait;

    protected $table = 'store_user';

    protected $guarded = [];
}
