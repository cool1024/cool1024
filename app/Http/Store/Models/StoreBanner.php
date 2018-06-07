<?php

/**
 * 商城幻灯片模型
 * 
 * @file   StoreBanner.php
 * @author xiaojian
 * @date   2018-04-30
 */
namespace App\Http\Store\Models;

use Illuminate\Database\Eloquent\Model;
use App\Api\Traits\Orm\DataSortTrait;

class StoreBanner extends Model
{
    use DataSortTrait;

    protected $table = 'store_banner';

    protected $guarded = [];
}
