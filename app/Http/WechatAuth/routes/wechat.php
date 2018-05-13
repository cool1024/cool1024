<?php

use App\Api\Contracts\ApiContract;
use App\Http\WechatAuth\Services\AuthContract;
use App\Http\WechatAuth\Classes\WechatPay;

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


// 微信登入第二步
$router->post('/auth/token', 'WechatController@getSessionKey');

$router->group(['middleware' => 'wechat'], function ($router) {

    // 获取我的个人信息
    $router->get('/user/info', function (ApiContract $api, AuthContract $auth) {
        return $api->getMessage($auth->user);
    });

});
