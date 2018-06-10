<?php

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

use App\Api\Contracts\FormContract;
use App\Sdk\JpushSdk;
use Carbon\Carbon;

// 简单的极光推送
$router->get('jpush/simple', function (FormContract $form) {
    $jpush = new JpushSdk('ef5bd8bf7208cf592ead3e73', '944c79cbe94ca3ac752ba6e8');
    $result = $jpush->simpleSend('测试推送一条简单消息 ' . Carbon::now());
    if ($result === true) {
        return $form->success('发送成功');
    }
    return $form->error($result);
});