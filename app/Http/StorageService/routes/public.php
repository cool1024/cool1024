<?php
$router->group(['middleware' => 'app-storage'], function ($router) {
    $router->get('upload/file', 'StorageController@uploadFile');
    $router->get('upload/image', 'StorageController@uploadImage');
    $router->get('oss/file', 'StorageController@ossFile');
});