<?php

/**
 * 存储控制器
 * 
 * @file   StorageController.php
 * @author xiaojian
 * @date   2018-04-04
 */
namespace App\Http\StorageService\Controllers;

use App\Api\BaseClass\Controller;

class StorageController extends Controller
{

    private $config;

    public function __construct(WechatContract $wechat)
    {
        parent::__construct();

        $this->config = [];

        // 尝试获取参数中的
        $params = $this->form->camelFormOrFail([['appid', 'required']]);

        // 尝试获取微信对象
        $this->wechat = $wechat->getWechatByAppId($params['appid'], $this->small_routine);
        if ($this->wechat === false) {
            abort(401, 'small routine lost');
        }
    }

    public function uploadFile()
    {

    }
}
