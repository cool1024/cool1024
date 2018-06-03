<?php

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