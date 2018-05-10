<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlatformOwnerTable extends Migration
{
    /**
     * 商家、KTV 小程序配置，每一个商户都有自己对应的一个小程序
     *
     * @return void
     */
    public function up()
    {
        Schema::create('platform_small_routine', function (Blueprint $table) {

            // 小程序唯一编号
            $table->increments('id');
            // 小程序所属店铺
            $table->unsignedInteger('store_id');
            // 小程序状态,是否可用
            $table->unsignedTinyInteger('is_active');
            // 小程序相关配置参数
            $table->text('config');
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
        Schema::dropIfExists('platform_small_routine');
    }
}
