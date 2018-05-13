<?php

/**
 * 微信用户登入模型
 * 
 * @file   WechatUserLogin.php
 * @author xiaojian
 * @date   2018-04-10
 */

namespace App\Http\WechatAuth\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * WechatUserLogin Class Model
 */
class WechatUserLogin extends Model
{
    protected $table = 'wechat_user_login';

    protected $hidden = [];

    protected $guarded = [];
}
