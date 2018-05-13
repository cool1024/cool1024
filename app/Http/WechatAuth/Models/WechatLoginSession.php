<?php

/**
 * 微信登入会话
 * 
 * @file   WechatLoginSession.php
 * @author xiaojian
 * @date   2018-04-27
 */
namespace App\Http\WechatAuth\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * WechatLoginSession Class Model
 */
class WechatLoginSession extends Model
{

    protected $table = 'wechat_login_session';

    protected $guarded = [];
}
