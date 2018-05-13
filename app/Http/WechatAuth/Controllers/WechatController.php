<?php

/**
 * 微信控制器
 * 
 * @file   WechatAuthController.php
 * @author xiaojian
 * @date   2018-04-04
 */
namespace App\Http\WechatAuth\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use App\Api\Contracts\ApiContract;
use App\Sdk\Wechat;
use App\Http\WechatAuth\Models\WechatUser;
use App\Http\WechatAuth\Models\WechatUserLogin;
use App\Http\WechatAuth\Services\AuthContract;
use App\Http\WechatAuth\Models\SmallRoutine;
use App\Http\WechatAuth\Models\WechatLoginSession;

/**
 * WechatController Class Controller
 */
class WechatController extends BaseController
{

    private $wechat;

    private $api;

    public function __construct(ApiContract $api)
    {
        $this->api = $api;
        // SmallRoutine::where('app_id')
        $this->wechat = new Wechat('wxdf65835c38ed456b', '7e68fd7551f9fe873ebf4ee9a25adf5e');
    }

    /**
     * 小程序登入第一步，code换取session_key
     */
    public function getSessionKey()
    {
        $required = ['code:max:45'];
        $params = $this->api->camelCaseParams($required);
        $session_datas = $this->wechat->getSmallRoutineSessionKey($params['code']);
        if (isset($session_datas['errcode'])) {
            return $this->api->error($session_datas['errmsg']);
        }
        WechatLoginSession::create([
            'appid' => $this->wechat->getAppId(),
            'openid' => $session_datas['openid'],
            'session_key' => $session_datas['session_key'],
        ]);
        return $this->api->getMessage($session_datas);
    }

    /**
     * 小程序登入第二步，用session_key和用户信息来换取令牌
     */
    public function getAuthToken()
    {
        $required = [
            'session_key:max:45',
            'avatarUrl:max:1000',
            'nickName:max:45',
            'gender:integer|min:0|max:2'
        ];
        $expected = [
            'city:max:45',
            'country:max:45',
            'province:max:45'
        ];
        $this->api->camelCaseParams($required, $expected);

    }

    /**
     * 用户信息更新，用平台token和用户信息来更新用户信息
     */
    public function updateUserInfo()
    {

    }

}
