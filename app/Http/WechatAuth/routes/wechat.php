<?php

use App\Api\Contracts\FormContract;
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


// 小程序登入第一步
$router->post('/session', 'WechatController@getSessionKey');

// 小程序登入第二步
$router->post('/signin', 'WechatController@getAuthToken');

$router->group(['middleware' => 'wechat'], function ($router) {

    // 更新我的个人信息
    $router->post('/update', 'WechatController@updateUserInfo');

    // 获取我的个人信息
    $router->get('/info', function (FormContract $api, AuthContract $auth) {
        return $api->getMessage($auth->user);
    });

});
