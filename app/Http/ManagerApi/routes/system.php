<?php

/**
 * 权限管理部分
 */

// 获取所有权限
$router->get('/permission/all', 'PermissionController@getAllPermissionWithGroup');
// 新增权限组
$router->post('/permission/group/insert', 'PermissionController@insertPermissionGroup');
// 更新权限组
$router->put('/permission/group/update', 'PermissionController@updatePermissionGroup');
// 删除权限组
$router->delete('/permission/group/delete', 'PermissionController@deletePermissionGroup');

// 新增权限
$router->post('/permission/insert', 'PermissionController@insertPermission');
// 更新权限
$router->put('/permission/update', 'PermissionController@updatePermission');
// 删除权限
$router->delete('/permission/delete', 'PermissionController@deletePermission');

/**
 * 菜单管理部分
 */

// 获取所有菜单数据
$router->get('/menu/all', 'MenuController@getAllMenu');
// 新增菜单分组
$router->post('/menu/group/insert', 'MenuController@insertMenuGroup');
// 更新菜单分组
$router->put('/menu/group/update', 'MenuController@updateMenuGroup');
// 删除菜单分组
$router->delete('/menu/group/delete', 'MenuController@deleteMenuGroup');
// 新增菜单
$router->post('/menu/insert', 'MenuController@insertMenu');
// 更新菜单
$router->put('/menu/update', 'MenuController@updateMenu');
// 删除菜单
$router->delete('/menu/delete', 'MenuController@deleteMenu');
// 权限下拉
$router->get('/menu/permission/options', 'MenuController@getPermissionOptions');
// 获取授权菜单
$router->get('/menu', 'MenuController@getAuthMenu');

/**
 * 系统登入部分
 */

// 用户登入
$router->post('/signin', 'AuthController@getAuthToken');
// 用户注册--开发时使用的测试接口，上线必须移除
$router->post('/signup', 'AuthController@signup');
// 检查令牌信息
$router->post('/check', 'AuthController@checkAuthToken');
// 销毁令牌
$router->post('/signout', 'AuthController@removeAuthToken');