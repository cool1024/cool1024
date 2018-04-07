<?php

/**
 * 路由解析器
 * 
 * @file  router.php
 * @autor xiaojian
 * @date  2018.4.3
 */

foreach ($router_groups as $value) {
    $file = $value['file'];
    $router->group(['namespace' => "App\Http\\$file\Controllers", 'prefix' => strtolower($file)], function ($router) use ($value) {
        foreach ($value['routers'] as $route_file) {
            require $route_file;
        }
    });
}