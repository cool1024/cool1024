<?php

/**
 * 商城商品类型模型
 * 
 * @file   StoreGoodsType.php
 * @author xiaojian
 * @date   2018-04-27
 */
namespace App\Http\Store\Models;

use Illuminate\Database\Eloquent\Model;
use App\Api\Traits\Orm\DataGroupTrait;

class StoreGoodsType extends Model
{
    use DataGroupTrait;

    protected $table = 'store_goods_type';

    protected $guarded = [];

    protected $groupConfig = [
        'groupKey' => 'parent_id',
        'groupParams' => ['id', 'goods_type_title', 'created_at']
    ];
}
