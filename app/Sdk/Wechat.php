<?php

/**
 * 微信登入方法
 * 1. 公众号登入
 * 2. 小程序登入
 * @file Wechat.php
 * @author xiaojian
 * @date 2018-06-10
 */

namespace App\Sdk;

class Wechat
{

    private $app_id;

    private $app_secret;

    public function __construct($app_id, $app_secret)
    {
        $this->app_id = $app_id;
        $this->app_secret = $app_secret;
    }

    /**
     * 公众号网页登入第一步：获取授权跳转链接
     * @param string $return_url 授权跳转链接，一般为微信登入第二步方法的接口
     * @param string $state 附带参数（根据需求自己定义，这个参数会在第二步带回来）
     * @return string 授权链接
     */
    public function authUrl($return_url, $state = 'STATE')
    {
        $params = [
            'appid' => $this->app_id,
            'redirect_uri' => $return_url,
            'response_type' => 'code',
            'scope' => 'snsapi_userinfo',
            'state' => $state
        ];

        $query_string = http_build_query($params);

        return "https://open.weixin.qq.com/connect/oauth2/authorize?$query_string#wechat_redirect";
    }

    /**
     * 公众号网页登入第二步：使用code获取accesstoken
     * @param string $code
     * @return array accesstoke
     */
    public function getAccessToken($code)
    {

        $params = [
            'appid' => $this->app_id,
            'secret' => $this->app_secret,
            'code' => $code,
            'grant_type' => 'authorization_code'
        ];
        $query_string = http_build_query($params);
        $api_url = "https://api.weixin.qq.com/sns/oauth2/access_token?$query_string";
        $access_token = json_decode(file_get_contents($api_url), true);
        return $access_token;
    }

    /**
     * 使用accesstoken换取用户信息
     * @param string $access_token
     * @param string $openid
     * @return array
     */
    public function getUserInfo($access_token, $openid)
    {
        $params = [
            'access_token' => $access_token,
            'openid' => $openid,
            'lang' => 'zh_CN'
        ];
        $query_string = http_build_query($params);
        $api_url = "https://api.weixin.qq.com/sns/userinfo?$query_string";
        $user_info = json_decode(file_get_contents($api_url), true);
        return $user_info;
    }

    /**
     * 微信小程序登入第一步，code换区session_key
     * @param string @code
     * @return array
     */
    public function getSmallRoutineSessionKey($code)
    {
        $params = [
            'appid' => $this->app_id,
            'secret' => $this->app_secret,
            'js_code' => $code,
            'grant_type' => 'authorization_code',
        ];
        $query_string = http_build_query($params);
        $api_url = "https://api.weixin.qq.com/sns/jscode2session?$query_string";
        $access_token = json_decode(file_get_contents($api_url), true);
        return $access_token;
    }

    /**
     * 获取当前的app_id
     */
    public function getAppId()
    {
        return $this->app_id;
    }
}