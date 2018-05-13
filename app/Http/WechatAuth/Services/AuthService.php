<?php

namespace App\Http\WechatAuth\Services;

use App\Http\WechatAuth\Models\WechatUser;
use App\Http\WechatAuth\Models\WechatUserLogin;
use App\Http\WechatAuth\Services\AuthContract;
use App\Http\WechatAuth\Models\SmallRoutine;
use App\Http\WechatAuth\Models\PlatformStore;

class AuthService implements AuthContract
{

    public $user;

    private $small_routine;

    private $store;

    public function __construct()
    {
        $this->user = new WechatUser();
    }

    public function checkToken($id, $store_id, $token)
    {

        $login = WechatUserLogin::where([
            'id' => $id,
            'store_id' => $store_id,
            'token' => $token,
        ])->first();

        if (!isset($login)) {
            return false;
        }

        $this->user = $this->user->find($login->uid);

        return isset($this->user);
    }

    public function getActiveSmallRoutine()
    {
        if (!isset($this->$small_routine)) {
            $this->$small_routine = SmallRoutine::where([
                'store_id' => $this->user->store_id,
                'is_active' => 1,
            ])->first();
        }

        if (!isset($this->$small_routine)) {
            return false;
        }

        return $this->$small_routine;
    }

    public function getActiveStore()
    {
        if (!isset($this->$store)) {
            $this->$store = PlatformStore::find($this->user->store_id);
        }

        if (!isset($this->$store)) {
            return false;
        }

        return $this->$store;
    }
}
