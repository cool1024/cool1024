<?php

/**
 * 商城订单商品模型
 * 
 * @file   StoreOrderGoods.php
 * @author xiaojian
 * @date   2018-04-27
 */
namespace App\Http\Store\Models;

use Illuminate\Database\Eloquent\Model;
use App\Api\Traits\Orm\SearchTrait;

class StoreOrderGoods extends Model
{

    protected $table = 'store_order_goods';

    protected $guarded = [];
}
