<?php

namespace App\Http\Admin\Models;

use Illuminate\Database\Eloquent\Model;
use App\Api\Traits\Orm\SearchTrait;

class AccessCompanyManager extends Model
{
    use SearchTrait;

    protected $table = 'access_company_manager';

    protected $hidden = ['password'];

    protected $guarded = [];
}
