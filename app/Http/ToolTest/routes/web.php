<?php

use App\Api\Contracts\ApiContract;
use App\Api\Contracts\FileContract;
use App\Api\Contracts\FormContract;
use App\Sdk\IdCardReader;
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
    return ['uploaded' => 1, 'url' => 'http://192.168.1.197/' . $file->saveFileByMd5('upload', 'upload')];
    // return $api->datas($file->saveFileByMd5('file', 'upload'));
});

// 使用FormService校验表单数据
$router->get('form', function (FormContract $form) {

    $rules = [
        ['a_b', 'required|integer|max:100'],
        ['b_c_d', 'required|string|max:45'],
        ['c', 'max:45'],
    ];

    // $formats = [
    //     'a' => 'abort_a',
    //     'b' => function ($key, $value) {
    //         return $key . $value;
    //     }
    // ];
    return dd($form->camelFormOrFail($rules, false));
});

// 使用身份证识别
$router->get('idcard', function (ApiContract $api) {
    $reader = new IdCardReader('6b0c12cf6b1386344dba1a61c6433db1', '0199ab7f344e4ad083cdae2444e7f261');
    $result = $reader->readFile('/home/xiaojian/桌面/timg.jpeg');
    return $result === false ? $api->error('接口调用失败') : $result;
});