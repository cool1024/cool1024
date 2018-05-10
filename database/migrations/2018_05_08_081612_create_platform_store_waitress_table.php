<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlatformStoreWaitressTable extends Migration
{
    /**
     * KTV/店铺服务员表，申请在表中，状态为 0
     *
     * @return void
     */
    public function up()
    {
        Schema::create('platform_store_waitress', function (Blueprint $table) {
            $table->increments('id');

            // 服务员所属的店铺
            $table->unsignedInteger('store_id');
            // 服务员头像         
            $table->string('waitress_avatar', 255);
            // 服务员姓名         
            $table->string('waitress_name', 45);
            // 服务员电话
            $table->string('waitress_phone', 45);
            // 籍贯
            $table->string('waitress_from', 100);
            // 年龄
            $table->unsignedTinyInteger('waitress_age');
            // 身高
            $table->unsignedTinyInteger('waitress_stature');
            // 爱好
            $table->string('waitress_hobby', 255);
            // 个人简介
            $table->string('waitress_introduction', 1000);
            // 状态：0-申请 1-禁用 2-启用 （移除使用软删除）
            $table->unsignedTinyInteger('waitress_status');

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
        Schema::dropIfExists('platform_store_waitress');
    }
}
