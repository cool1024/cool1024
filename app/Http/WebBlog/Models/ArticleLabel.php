<?php

namespace App\Http\WebBlog\Models;

use Illuminate\Database\Eloquent\Model;
use App\Api\Traits\Orm\SearchTrait;

class ArticleLabel extends Model
{
    use SearchTrait;

    protected $guarded = [];
}
