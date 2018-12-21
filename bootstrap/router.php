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
    $git_path = realpath(__DIR__ . '/..');
    return $_GET['password'] !== $password ? 'ERROR' : $git_path;
});

$router->get('/phpunit', function () {

    // 安全密码
    $password = env('DEV_PASSWORD', '这个是安全密码，需要自己去env文件中设置');

    if ($password != $_GET['password']) {
        return ['result' => false, 'message' => 'password error'];
    }

    // 日志文件夹路径
    $logDirPath = realpath(__DIR__ . '/../storage/logs/tests');

    // 获取所有的日志文件
    $logFiles = [];
    if (is_dir($logDirPath)) {
        $fileHandle = opendir($logDirPath);
        while (($file = readdir($fileHandle)) !== false) {
            // 跳过上级和当前目录
            if ($file == '.' || $file == '..') {
                continue;
            }

            $filePath = realpath($logDirPath . '/' . $file);
            if (is_file($filePath)) {
                $logFiles[] = $filePath;
            }
        }
    }
    return ['result' => true, 'message' => 'success', 'datas' => $logFiles];
});

$router->get('/phpunit', function () {

    // 日志文件夹路径
    $logDirPath = realpath(__DIR__ . '/../storage/logs/tests');

    if (isset($_GET['log'])) {
        // 获取指定日志记录
        $filePath = $logDirPath . '/' . $_GET['log'];
        if (is_file($filePath)) {
            return ['result' => true, 'message' => 'success', 'datas' => file_get_contents($filePath)];
        } else {
            return ['result' => false, 'message' => '日志文件不存在'];
        }

    } else {
        // 获取所有的日志文件
        $logFiles = [];
        if (is_dir($logDirPath)) {
            $fileHandle = opendir($logDirPath);
            while (($file = readdir($fileHandle)) !== false) {
        // 跳过上级和当前目录
                if ($file == '.' || $file == '..') {
                    continue;
                }

                $filePath = realpath($logDirPath . '/' . $file);
                if (is_file($filePath)) {
                    $logFiles[] = $file;
                }
            }
        }
        return ['result' => true, 'message' => 'success', 'datas' => $logFiles];
    }
});