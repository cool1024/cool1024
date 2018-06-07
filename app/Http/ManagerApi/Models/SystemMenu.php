<?php

/**
 * 系统菜单模型
 * @author xiaojian
 * @file SystemMenu.php
 * @date 2018-5-29
 */

namespace App\Http\ManagerApi\Models;

use Illuminate\Database\Eloquent\Model;
use App\Api\Traits\Orm\DataSortTrait;
use App\Api\Traits\Orm\PageTrait;

class SystemMenu extends Model
{

    use DataSortTrait, PageTrait;

    protected $table = 'system_menu';

    protected $guarded = [];
}
