<?php

namespace App\Http\StorageService\Models;

use Illuminate\Database\Eloquent\Model;
use App\Api\Traits\Orm\PageTrait;

class ServiceCompany extends Model
{
    use PageTrait;

    protected $table = 'service_company';
    protected $hidden = ['token'];
    protected $guarded = [];
}
