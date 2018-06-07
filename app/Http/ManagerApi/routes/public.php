<?php

use App\Http\ManagerApi\Models\SystemMenu;

/**
 * 公用模块路由
 * @author xiaojian
 * @file public.php
 * @date 2018-5-29
 */

/**
 * 公开文件上传
 */
$router->group(['middleware' => 'managerapi'], function ($router) {
    $router->get('/quill', 'OssController@quillExampleUpload');
});

$router->get('/search', function () {
    $params = [
        'limit' => 10,
        'offset' => 0,
        'menu_title' => '系统',
    ];
    $wheres = [
        ['where', 'menu_title', 'like', '$menu_title']
    ];
    $formats = [
        'menu_title' => function ($value) {
            return "%$value%";
        },
    ];
    return with(new SystemMenu())->pagination($params, $wheres, $formats);
});