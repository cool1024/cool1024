<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWechatUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wechat_user', function (Blueprint $table) {

            $table->increments('id');

            // 微信信息
            $table->string('openid', 45);
            $table->string('realname', 45);
            $table->string('mobile', 45);
            $table->string('nickname', 45);
            $table->string('headimgurl', 255);
            $table->string('address', 45);
            $table->unsignedTinyInteger('gender');
            $table->string('city', 45);
            $table->string('country', 45);
            $table->string('province', 45);

            // 商户唯一编号,用户所属商户
            $table->unsignedInteger('store_id');
            // 唯一员工号-没有员工号的是普通用户（老板，经理，服务人员都有）
            $table->unsignedInteger('woker_id');

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
        Schema::dropIfExists('wechat_user');
    }
}
