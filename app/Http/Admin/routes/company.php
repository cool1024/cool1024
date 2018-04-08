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
$router->get('/company/get', 'companyController@getCompany');
// 添加公司
$router->post('/company/insert', 'CompanyController@insertCompany');
// 删除公司
$router->delete('/company/delete', 'companyController@deleteCompany');
// 修改公司
// $router->post('/company/update', 'companyController@addcompanyLabel');
// // 获取公司列表-分页
// $router->get('/company/list', 'companyController@companyLabels');