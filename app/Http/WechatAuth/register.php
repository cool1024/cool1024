<?php
$app->routeMiddleware([
    'wechat' => 'App\Http\WechatAuth\Middlewares\WechatAuthMiddleware',
]);

$app->register(App\Http\WechatAuth\Services\AuthServiceProvider::class);