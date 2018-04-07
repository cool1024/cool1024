<?php

/**
 * Http目录解析器
 * 
 * @file  analyse.php
 * @autor xiaojian
 * @date  2018.4.3
 */

 // Http目录路径
$http_model_dir = realpath(__DIR__ . '/../app/Http');

// 打开http目录
$file_handle = opendir($http_model_dir);

// 注册文件列表
$registers = [];

// 路由分组文件列表
$router_groups = [];

// 循环解析目录
while (($file = readdir($file_handle)) !== false) {

    // 跳过上级和当前目录
    if ($file == '.' || $file == '..') {
        continue;
    }

    // 获取当前打开的目录路径
    $dir_path = realpath($http_model_dir . '/' . $file);

    // 判断路径是否是一个文件夹
    if (is_dir($dir_path)) {

        // 尝试获取register.php
        $register_file = realpath($dir_path . '/register.php');
        if (is_file($register_file)) {
            $registers[] = $register_file;
        }

        //载入路由文件
        $dir_path = realpath($dir_path . '/routes');
        if (is_dir($dir_path)) {

            $dir_handle = opendir($dir_path);

            $temp_group = ['file' => $file, 'routers' => []];

            while (($file = readdir($dir_handle)) !== false) {

                $route_file = realpath($dir_path . '/' . $file);

                // 如果文件不是文件夹的话，就装载这个文件
                if (!is_dir($route_file)) {
                    $temp_group['routers'][] = $route_file;
                }
            }
            $router_groups[] = $temp_group;
        }
    }
}