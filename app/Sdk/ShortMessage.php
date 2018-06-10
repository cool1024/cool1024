<?php

/**
 * 短信发送类
 * @file ShortMessage.php
 * @author zhaoshiwei
 * @date 2018年3月12日
 */

namespace App\Sdk;

class ShortMessage
{
    private $apikey; //= '87c1132c1c766fb5e812642ddb10c4c8';

    /**
     * 构造函数
     * 修改为您的apikey(https://www.yunpian.com)登陆官网后获取
     * @param stirng $apiKey
     */
    public function __construct($api_key)
    {
        $this->apikey = $api_key;
    }

    /**
     * 云片网单发信息发送请求
     * @author zhaoshiwei
     * @param string $mobile
     * @param string $content
     * @return bool 发送结果
     */
    public function singleSend($mobile, $content)
    {

        $ch = curl_init();
        // 设置验证方式
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept:text/plain;charset=utf-8', 'Content-Type:application/x-www-form-urlencoded', 'charset=utf-8'));
        // 设置返回结果为流
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // 设置超时时间
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        // 设置通信方式
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        //发送短信
        $data = array('text' => $content, 'apikey' => $this->apikey, 'mobile' => $mobile);

        curl_setopt($ch, CURLOPT_URL, 'https://sms.yunpian.com/v2/sms/single_send.json');
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        //保存发送短信的结果
        $array = json_decode(curl_exec($ch), true);

        if ($array['msg'] == '发送成功') {
            return true;
        } else {
            return false;
        }
    }
}