<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWechatLoginSessionTable extends Migration
{
    /**
     * 微信登入会话表
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wechat_login_session', function (Blueprint $table) {

            $table->increments('id');

            $table->string('appid', 45);
            $table->string('openid', 45);
            $table->string('session_key', 45);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wechat_login_session');
    }
}
