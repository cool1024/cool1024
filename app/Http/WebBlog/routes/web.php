<?php

use App\Api\Contracts\FileContract;
use App\Api\Contracts\ApiContract;

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
$router->post('/article/label/add', 'ArticleController@addArticleLabel');
$router->delete('/article/label/delete', 'ArticleController@deleteArticleLabel');
$router->get('/article/label/list', 'ArticleController@articleLabels');

$router->post('/article/add', 'ArticleController@addArticle');
$router->delete('/article/delete', 'ArticleController@deleteArticle');
$router->get('/article/list', 'ArticleController@articles');

$router->post('/tools-ui/upload', function (FileContract $file, ApiContract $api) {
    return [
        'uploaded' => 1,
        'url' => 'http://127.0.0.1/' . $file->saveFileByMd5('upload', 'upload')
    ];
});