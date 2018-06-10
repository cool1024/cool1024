<?php

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
$router->get('format/string', function (FormContract $api) {
    return 'test string datas';
});

// 响应数据格式化中间件测试--重定向
$router->get('format/redirect', function (FormContract $api) {
    return redirect('tooltest/format/string');
});

// 响应数据格式化中间件测试--返回数组
$router->get('format/array', function (FormContract $api) {
    return $api->datas(['article_title' => 'test title', 'article_type' => 20]);
});

// 响应数据格式化中间件测试--返回试图
$router->get('format/view', function (FormContract $api) {
    return view('simple', ['name' => 'lumen']);
});

// 使用FormService校验表单数据
$router->get('form', function (FormContract $form) {

    $rules = [
        ['a_b', 'required|integer|max:100'],
        ['b_c_d', 'required|string|max:45'],
        // 没有required的参数是可选参数
        ['c', 'max:45'],
    ];

    $formats = [
        // 将会把参数a变为abort_a
        'a' => 'abort_a',
        // $key为原来参数名‘b’,$value为参数的值，这个返回值$key.$value为新的参数名称替换掉'b'
        'b' => function ($key, $value) {
            return $key . $value;
        }
    ];

    // 使用checkForm系列的方法可以自定义参数名称格式化
    // $params = $form->chekFormOrFail($rules, $formats);

    // 使用camelForm系列的方法将会强制要求参数为小驼峰，而方法返回值依旧可以保持之前的下划线
    $params = $form->camelFormOrFail($rules);

    return $params;
});

// 使用身份证识别
$router->post('idcard', function (FormContract $api) {
    $params = $api->checkFormOrFail(['base64']);
    $reader = new IdCardReader('6b0c12cf6b1386344dba1a61c6433db1', '0199ab7f344e4ad083cdae2444e7f261');
    $result = $reader->readBase64($params['base64']);
    return $result === false ? $api->error('接口调用失败') : $api->datas($result);
});