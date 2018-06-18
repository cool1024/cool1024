<?php

/**
 * 微信控制器
 * 
 * @file   WechatAuthController.php
 * @author xiaojian
 * @date   2018-04-04
 */
namespace App\Http\WechatAuth\Controllers;

use App\Api\Contracts\ApiContract;
use App\Sdk\Wechat;
use App\Http\WechatAuth\Models\WechatUser;
use App\Http\WechatAuth\Models\WechatUserLogin;
use App\Http\WechatAuth\Services\AuthContract;
use App\Http\WechatAuth\Models\SmallRoutine;
use App\Http\WechatAuth\Models\WechatLoginSession;
use App\Http\WechatAuth\Services\WechatContract;
use App\Api\BaseClass\Controller;

/**
 * WechatController Class Controller
 */
class WechatController extends Controller
{

    private $wechat;

    private $small_routine;

    private $store;

    public function __construct(WechatContract $wechat)
    {
        parent::__construct();

        // 尝试获取参数中的
        $params = $this->form->camelFormOrFail([['appid', 'required']]);

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
        $rules = [['code', 'required|max:45']];
        $params = $this->form->camelFormOrFail($rules);
        $session_datas = $this->wechat->getSmallRoutineSessionKey($params['code']);
        if (isset($session_datas['errcode'])) {
            return $this->form->error($session_datas['errmsg']);
        }
        $session_datas = WechatLoginSession::create([
            'appid' => $this->wechat->getAppId(),
            'openid' => $session_datas['openid'],
            'session_key' => $session_datas['session_key'],
        ]);
        return $this->form->getMessage($session_datas);
    }

    /**
     * 小程序登入第二步，用session_key和用户信息来换取令牌
     */
    public function getAuthToken()
    {
        $rules = [
            ['openid', 'required|max:45'],
            ['session_key', 'required|max:45'],
            ['avatar_url', 'required|max:1000'],
            ['nick_name', 'required|max:45'],
            ['gender', 'required|integer|min:0|max:2'],
            ['city', 'max:45'],
            ['country', 'max:45'],
            ['province', 'max:45']
        ];

        $params = $this->form->camelFormOrFail($rules);

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

        return $this->form->getMessage($login);
    }

    /**
     * 用户信息更新
     */
    public function updateUserInfo()
    {
        $rules = [
            ['openid', 'required|max:45'],
            ['avatar_url', 'required|max:1000'],
            ['nick_name', 'required|max:45'],
            ['gender', 'required|integer|min:0|max:2'],
            ['city', 'max:45'],
            ['country', 'max:45'],
            ['province', 'max:45']
        ];

        $params = $this->form->camelFormOrFail($rules);

        $this->auth->fill($params)->save();

        return $this->getMessage();
    }

}
