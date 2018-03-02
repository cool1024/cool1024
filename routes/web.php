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

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->get('/randomkey', function () {
    return str_random(32);
});

// HTTP目录路径
$http_model_dir = realpath(__DIR__ . '/../app/Http');

// 打开HTTP目录
$file_handle = opendir($http_model_dir);

// 载入HTTP目录下的所有路由文件
while (($file = readdir($file_handle)) !== false) {
    if ($file == '.' || $file == '..') {
        continue;
    }
    $dir_path = realpath($http_model_dir . '/' . $file);
    if (is_dir($dir_path)) {
        $dir_path = realpath($dir_path . '/routes');
        $dir_handle = opendir($dir_path);
        $router->group(['namespace' => "App\Http\\$file\Controllers", 'prefix' => strtolower($file)], function ($router) use ($dir_handle, $dir_path) {
            while (($file = readdir($dir_handle)) !== false) {
                $route_file = realpath($dir_path . '/' . $file);
                if (!is_dir($route_file)) {
                    require $route_file;
                }
            }
        });
    }
}