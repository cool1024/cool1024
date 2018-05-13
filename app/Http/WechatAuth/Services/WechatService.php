<?php

namespace App\Http\WechatAuth\Services;

use App\Sdk\Wechat;
use App\Sdk\WechatPay;

class WechatService implements AuthContract
{

    private $config;

    /**
     * 载入配置参数
     */
    public function loadConfig($config)
    {
        $config = json_decode($config);
    }

    /**
     * 获取微信对象-提供了微信登入方法
     */
    public function getWechatObject()
    {
        return new Wechat($this->config->appId, $this->config->appSecret);
    }

    /**
     * 获取微信支付对象-提供了微信支付方法
     */
    public function getWechatPayObject()
    {
        $config = [
            'app_id' => $this->config->appId,
            'mch_id' => $this->config->appId,
            'secret_key' => $this->config->appId,
            'notify_url' => $this->config->notifyUrl,
            'return_url' => $this->config->returnUrl,
            'pre_pay_url' => $this->config->prePayUrl,
        ];

        return new WechatPay($config);
    }
}
