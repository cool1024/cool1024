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

use App\Api\Contracts\FormContract;
use App\Sdk\OssSdk;

// oss上传图片授权
$router->get('oss/access/image', function (FormContract $form) {

    // 示例化OssSdk
    $oss = new OssSdk('LTAIJUKgjPNJtHW3', '7R0o8odjGB8eKZm3rrwTC8m9sjYxFh', 'https://hello1024.oss-cn-beijing.aliyuncs.com');

    // 生成文件保存地址
    $file_path = 'upload/' . date('Ymdhis') . uniqid();

    // 800k设置
    return $form->getMessage($oss->getAccessDatas(1024 * 800, 10, $file_path));
});