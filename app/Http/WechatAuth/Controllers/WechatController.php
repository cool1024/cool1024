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
use App\Http\WechatAuth\Services\WechatContract;

/**
 * WechatController Class Controller
 */
class WechatController extends BaseController
{

    private $wechat;

    private $api;

    private $small_routine;

    private $store;

    public function __construct(ApiContract $api, WechatContract $wechat)
    {
        $this->api = $api;

        // 尝试获取参数中的
        $params = $api->camelCaseParams(['appid']);

        // 尝试获取微信对象
        $this->wechat = $wechat->getWechatByAppId($params['appid'], $this->small_routine);
        if ($this->wechat === false) {
            abort(401, 'small routine lost');
        }
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
        $session_datas = WechatLoginSession::create([
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
            'openid:max:45',
            'session_key:max:45',
            'avatar_url:max:1000',
            'nick_name:max:45',
            'gender:integer|min:0|max:2'
        ];
        $expected = [
            'city:max:45',
            'country:max:45',
            'province:max:45'
        ];


        $params = $this->api->camelCaseParams($required, $expected);

        $user = WechatUser::where([
            'store_id' => $this->small_routine->store_id,
            'openid' => $params['openid'],
        ])->first();

        if (!isset($user)) {
            $user = new WechatUser();
        }

        unset($params['session_key']);
        $user->fill($params)->save();

        $login = WechatUserLogin::where('uid', $user->id)->first();
        if (!isset($login)) {
            $login = new WechatUserLogin();
        }
        $login->fill([
            'uid' => $user->id,
            'store_id' => $user->store_id,
            'token' => md5($user->id) . sha1(uniqid()),
        ]);

        return $this->api->getMessage($login);
    }

    /**
     * 用户信息更新
     */
    public function updateUserInfo()
    {
        $required = [
            'openid:max:1000',
            'avatar_url:max:1000',
            'nick_name:max:45',
            'gender:integer|min:0|max:2'
        ];

        $expected = [
            'city:max:45',
            'country:max:45',
            'province:max:45'
        ];

        $params = $this->api->camelCaseParams($required, $expected);

        $this->auth->fill($params)->save();

        return $this->getMessage();
    }

}
