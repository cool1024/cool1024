<?php

/**
 * 商城商品模型
 * 
 * @file   StoreGoods.php
 * @author xiaojian
 * @date   2018-04-30
 */
namespace App\Http\Store\Models;

use Illuminate\Database\Eloquent\Model;
use App\Api\Traits\Orm\PageTrait;

class StoreGoods extends Model
{
    use PageTrait;

    protected $table = 'store_goods';

    protected $guarded = [];
}
