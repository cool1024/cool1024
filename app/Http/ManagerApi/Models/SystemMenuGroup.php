<?php

/**
 * 系统菜单组模型
 * @author xiaojian
 * @file SystemMenuGroup.php
 * @date 2018-5-29
 */

namespace App\Http\ManagerApi\Models;

use Illuminate\Database\Eloquent\Model;
use App\Api\Traits\Orm\DataSortTrait;

class SystemMenuGroup extends Model
{

    use DataSortTrait;

    protected $table = 'system_menu_group';

    protected $guarded = [];
}
