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

// 获取指定平台管理员
$router->get('/platform/get', 'PlatformManagerController@getPlatformManager');
// 添加平台管理员
$router->post('/platform/insert', 'PlatformManagerController@insertPlatformManager');
// 修改平台管理员
$router->put('/platform/update', 'PlatformManagerController@updatePlatformManager');
// 删除平台管理员
$router->delete('/platform/delete', 'PlatformManagerController@deletePlatformManager');
// 获取平台管理员列表-分页
$router->get('/platform/search', 'PlatformManagerController@searchPlatformManager');