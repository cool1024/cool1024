<?php

namespace App\Http\WechatAuth\Services;

interface WechatContract
{

    /**
     * 载入配置参数
     */
    public function loadConfig($config);

    /**
     * 获取微信对象-提供了微信登入方法
     */
    public function getWechatObject();

    /**
     * 获取微信支付对象-提供了微信支付方法
     */
    public function getWechatPayObject();
}
