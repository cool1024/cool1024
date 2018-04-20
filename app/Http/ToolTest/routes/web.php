<?php

use App\Api\Contracts\ApiContract;
use App\Api\Contracts\FileContract;

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

// 响应数据格式化中间件测试--返回字符串
$router->get('format/string', function (ApiContract $api) {
    return 'test string datas';
});

// 响应数据格式化中间件测试--重定向
$router->get('format/redirect', function (ApiContract $api) {
    return redirect('tooltest/format/string');
});

// 响应数据格式化中间件测试--返回数组
$router->get('format/array', function (ApiContract $api) {
    return $api->datas(['article_title' => 'test title', 'article_type' => 20]);
});

// 响应数据格式化中间件测试--返回试图
$router->get('format/view', function (ApiContract $api) {
    return view('simple', ['name' => 'lumen']);
});

 // 使用文件服务上传文件
$router->post('upload', function (FileContract $file, ApiContract $api) {
    return ['uploaded' => 1, 'url' => 'http://127.0.0.1/' . $file->saveFileByMd5('upload', 'upload')];
    // return $api->datas($file->saveFileByMd5('file', 'upload'));
});