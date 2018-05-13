<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWechatUserLoginTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wechat_user_login', function (Blueprint $table) {
            
            // 记录编号
            $table->increments('id');
            // 用户唯一编号
            $table->unsignedInteger('uid');
            // 登入令牌
            $table->string('token', 255);
            // 商户唯一编号,用户所属商户
            $table->unsignedInteger('store_id');
            // 唯一员工号-没有员工号的是普通用户（老板，经理，服务人员都有）
            $table->unsignedInteger('work_id');
            // 时间戳
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
        Schema::dropIfExists('wechat_user_login');
    }
}
