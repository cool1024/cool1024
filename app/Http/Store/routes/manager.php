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

// 获取指定用户
$router->get('/user/get', 'ManagerStoreUserController@getUser');
// 修改指定用户
$router->put('/user/update', 'ManagerStoreUserController@updateUser');
// 获取会员列表-分页
$router->get('/user/search', 'ManagerStoreUserController@searchUser');
// 获取会员等级下拉
$router->get('/user/level/options', 'ManagerStoreUserController@getUserLevelOptions');

// 获取所有商品总类
$router->get('/goodstype/list', 'ManagerStoreGoodsTypeController@listGoodsType');
// 删除指定的商品分类
$router->delete('/goodstype/delete', 'ManagerStoreGoodsTypeController@deleteGoodsType');
// 保存分类组
$router->put('/goodstype/save', 'ManagerStoreGoodsTypeController@saveGoodsType');


// 订单查询
$router->get('/order/search', 'MangerStoreOrderController@searchOrder');
// 订单详情
$router->get('/order/get', 'MangerStoreOrderController@getOrder');

// 查询商品-分页
$router->get('/goods/search', 'MangerStoreGoodsController@searchGoods');
// 获取商品详情
$router->get('/goods/get', 'MangerStoreGoodsController@getGoods');
// 保存商品规格
$router->put('goods/specification/update', 'MangerStoreGoodsController@saveGoodsSpecification');
// 获取商品下拉选项
$router->get('/goods/type/options', 'MangerStoreGoodsController@getGoodsTypeOptions');
// 添加商品
$router->post('goods/insert', 'MangerStoreGoodsController@insertGoods');
// 保存商品
$router->put('goods/update', 'MangerStoreGoodsController@updateGoods');
// 删除商品
$router->delete('goods/delete', 'MangerStoreGoodsController@deleteGoods');
// 商品图片上传授权
$router->get('goods/image/access', 'MangerStoreGoodsController@ossUpload');