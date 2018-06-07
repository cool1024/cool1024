<?php

use App\Api\Contracts\ApiContract;
use App\Http\WebBlog\Models\Article;

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
 */

// 添加文章标签
$router->post('/article/label/add', 'ArticleController@addArticleLabel');
// 删除文章标签
$router->delete('/article/label/delete', 'ArticleController@deleteArticleLabel');
// 获取所有文章标签
$router->get('/article/label/list', 'ArticleController@articleLabels');

// 添加文章
$router->post('/article/add', 'ArticleController@addArticle');
// 删除文章
$router->delete('/article/delete', 'ArticleController@deleteArticle');
// 获取文章列表，分页
$router->get('/article/list', 'ArticleController@articles');

$router->get('/test', function () {
    // return Article::find(3);
    // return Article::find(3)->articleLabel;
    return Article::with('articleLabel')->find(3);
});