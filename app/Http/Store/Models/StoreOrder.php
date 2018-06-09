<?php

/**
 * 商城订单模型
 * 
 * @file   StoreOrder.php
 * @author xiaojian
 * @date   2018-04-27
 */
namespace App\Http\Store\Models;

use Illuminate\Database\Eloquent\Model;
use App\Api\Traits\Orm\PageTrait;

class StoreOrder extends Model
{
    use PageTrait;

    protected $table = 'store_order';

    protected $guarded = [];

    function goodsList()
    {
        return $this->hasMany('App\Http\Store\Models\StoreOrderGoods', 'order_id', 'id');
    }

    function user()
    {
        return $this->belongsTo('App\Http\Store\Models\StoreUser', 'uid', 'id');
    }
}
