<?php

namespace App\Http\WechatAuth\Services;

interface AuthContract
{
    public function checkToken($id, $token);
}
