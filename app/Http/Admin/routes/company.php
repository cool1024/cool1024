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

// 获取指定公司
$router->get('/company/get', 'CompanyController@getCompany');
// 添加公司
$router->post('/company/insert', 'CompanyController@insertCompany');
// 修改公司
$router->put('/company/update', 'CompanyController@updateCompany');
// 删除公司
$router->delete('/company/delete', 'CompanyController@deleteCompany');
// 获取公司列表-分页
$router->get('/company/search', 'CompanyController@searchCompany');
// 公司图片授权上传
$router->get('/company/image/access', 'CompanyController@ossUpload');