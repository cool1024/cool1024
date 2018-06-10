<?php

/**
 * 极光推送
 * @file JpushSdk.php
 * @author xiaojian
 * @date 2018-06-10
 */

namespace App\Sdk;

use JPush\Client as JPush;

class JpushSdk
{

    private $app_key;
    private $master_secret;

    /**
     * 构造函数
     * @param string $app_key
     * @param string $master_secret
     */
    public function __construct($app_key, $master_secret)
    {
        $this->app_key = $app_key;
        $this->master_secret = $master_secret;
    }

    /**
     * 简单推送，给所有人所有平台推送消息
     * @param string $message
     * @return boolean|JPushException
     */
    public function simpleSend($message)
    {
        $client = new JPush($this->app_key, $this->master_secret);
        $pusher = $client->push()
            ->setPlatform('all')
            ->addAllAudience()
            ->setNotificationAlert($message);
        try {
            $pusher->send();
            return true;
        } catch (\JPush\Exceptions\JPushException $e) {
            return $e;
        }
    }

    /**
     * 定点推送，推送指定的人
     * @param string $message
     * @return boolean|JPushException
     */
    public function targetSend($registration_id, $message)
    {

        $client = new JPush($this->app_key, $this->master_secret);
        $pusher = $client->push()
            ->setPlatform('all')
            ->addRegistrationId($registration_id)
            ->setNotificationAlert($message);
        try {
            $pusher->send();
            return true;
        } catch (\JPush\Exceptions\JPushException $e) {
            return $e;
        }
    }
}