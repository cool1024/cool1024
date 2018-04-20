<?php

namespace App\Http\Admin\Models;

use Illuminate\Database\Eloquent\Model;
use App\Api\Traits\Orm\SearchTrait;

class AccessPlatformManager extends Model
{
    use SearchTrait;

    protected $table = 'access_platform_manager';

    protected $hidden = ['password'];

    protected $guarded = [];

    protected $casts = [
        'is_active' => 'int'
    ];
}
