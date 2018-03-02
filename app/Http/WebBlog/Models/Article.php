<?php

namespace App\Http\WebBlog\Models;

use Illuminate\Database\Eloquent\Model;
use App\Api\Traits\Orm\SearchTrait;

class Article extends Model
{
    use SearchTrait;

    protected $guarded = [];
}
