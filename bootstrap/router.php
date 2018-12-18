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
    return redirect('/ng');
});

$router->get('/randomkey', function () {
    return str_random(32);
});

$router->get('/pull', function () {
    // 安全密码
    $password = env('GIT_PULL_PASSWORD', '这个是安全密码，需要自己去env文件中设置');
    // 仓库路径
    $git_path = realpath(__DIR__ . '/../../');
    return $_GET['password'] !== $password ? 'ERROR' : $git_path;
});