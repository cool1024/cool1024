<?php

/**
 * 微信用户模型
 * 
 * @file   WechatUser.php
 * @author xiaojian
 * @date   2018-04-27
 */
namespace App\Http\WechatAuth\Models;

use Illuminate\Database\Eloquent\Model;

class WechatUser extends Model
{

    protected $table = 'wechat_user';

    protected $guarded = [];
}
