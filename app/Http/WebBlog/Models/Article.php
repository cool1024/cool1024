<?php

namespace App\Http\WebBlog\Models;

use Illuminate\Database\Eloquent\Model;
use App\Api\Traits\Orm\SearchTrait;

class Article extends Model
{
    use SearchTrait;

    protected $guarded = [];

    /**
     * 获取博客文章的评论
     */
    public function articleLabel()
    {
        return $this->belongsTo('App\Http\WebBlog\Models');
    }
}
