<?php
$app->routeMiddleware([
    'managerapi' => 'App\Http\ManagerApi\Middlewares\AuthMiddleware'
]);