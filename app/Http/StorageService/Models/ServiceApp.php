<?php

namespace App\Http\StorageService\Models;

use Illuminate\Database\Eloquent\Model;
use App\Api\Traits\Orm\PageTrait;

class ServiceApp extends Model
{
    use PageTrait;

    protected $table = 'service_app';
    protected $guarded = [];

}
