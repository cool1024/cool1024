<?php

namespace App\Http\WechatAuth\Services;

interface AuthContract
{
    public function checkToken($id, $store_id, $token);

    public function getActiveStore();

    public function getActiveSmallRoutine();
}
