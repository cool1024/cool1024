<?php

/**
 * 权限管理部分
 */

// 获取所有权限
$router->get('/permission/all', 'PermissionController@getAllPermissionWithGroup');