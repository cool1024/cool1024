<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlatformStoreSalesManagerTable extends Migration
{
    /**
     * 平台员工权限表（开通对应功能）
     *
     * @return void
     */
    public function up()
    {
        Schema::create('platform_worker_permission', function (Blueprint $table) {

            // 权限唯一编号
            $table->increments('id');
            // 权限分组标题（同一分组标题的权限会放在一起）         
            $table->string('group_title', 45);
            // 权限关键词
            $table->string('permission_key', 45);
            // 权限/功能名称
            $table->string('permission_name', 45);
            // 权限描述说明       
            $table->string('permission_description', 500);
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
        Schema::dropIfExists('platform_worker_permission');
    }
}
