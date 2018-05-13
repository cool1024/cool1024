<?php

namespace App\Http\WechatAuth\Services;

use App\Sdk\Wechat;
use App\Sdk\WechatPay;
use App\Http\WechatAuth\Models\SmallRoutine;

class WechatService implements WechatContract
{

    private $config;

    /**
     * 载入配置参数
     * 
     * @param $config string
     */
    public function loadConfig($config)
    {
        $config = json_decode($config);
    }

    /**
     * 通过appid获取微信对象，并返回小程序ORM对象
     */
    public function getWechatByAppId($app_id, &$small_routine)
    {
        // 获取小程序配置参数
        $small_routine = SmallRoutine::where('app_id', $app_id)->first();
        if (!isset($small_routine)) {
            return false;
        }
        $config = json_decode($small_routine->config);

        // 初始化小程序对象
        return new Wechat($config->appId, $config->appSecret);
    }

    /**
     * 获取小程序配置参数
     */


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
            'mch_id' => $this->config->mchId,
            'secret_key' => $this->config->appSecret,
            'notify_url' => $this->config->notifyUrl,
            'return_url' => $this->config->returnUrl,
            'pre_pay_url' => $this->config->prePayUrl,
        ];

        return new WechatPay($config);
    }
}
