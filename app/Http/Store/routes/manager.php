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

// 获取指定公司
$router->get('/user/get', 'ManagerStoreUserController@getUser');
// 修改公司
$router->put('/user/update', 'ManagerStoreUserController@updateUser');
// 获取公司列表-分页
$router->get('/user/search', 'ManagerStoreUserController@searchUser');
// 获取会员等级下拉
$router->get('/user/level/options', 'ManagerStoreUserController@getUserLevelOptions');