<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlatformStoreTable extends Migration
{
    /**
     * 商家、KTV
     *
     * @return void
     */
    public function up()
    {
        Schema::create('platform_store', function (Blueprint $table) {

            // 店铺唯一编号，对应store_id
            $table->increments('id');
            // 店铺名称
            $table->string('store_name', 100);
            // 店铺头像
            $table->string('store_logo', 200);
            // 店铺展示图
            $table->string('store_images', 200);
            // 店铺介绍
            $table->string('store_description', 1000);
            // 店铺地址
            $table->string('store_address', 200);
            // 店铺负责人
            $table->string('store_manager_name', 100);
            // 负责人电话
            $table->string('store_manager_mobile', 20);
            // 是否启用店铺
            $table->unsignedTinyInteger('is_active');
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
        Schema::dropIfExists('platform_store');
    }
}
