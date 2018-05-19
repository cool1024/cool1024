<?php

namespace App\Http\ManagerApi\Models;

use Illuminate\Database\Eloquent\Model;
use App\Api\Traits\Orm\DataSortTrait;

class SystemMenuGroup extends Model
{

    use DataSortTrait;

    protected $table = 'system_menu_group';

    protected $guarded = [];
}
