<?php

namespace App\Http\ManagerApi\Models;

use Illuminate\Database\Eloquent\Model;
use App\Api\Traits\Orm\DataSortTrait;

class SystemMenu extends Model
{

    use DataSortTrait;

    protected $table = 'system_menu';

    protected $guarded = [];
}
