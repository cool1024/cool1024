<?php

namespace App\Http\ManagerApi\Models;

use Illuminate\Database\Eloquent\Model;

class SystemUser extends Model
{
    protected $table = 'system_user';

    protected $guarded = [];

    protected $hidden = ['password'];
}
