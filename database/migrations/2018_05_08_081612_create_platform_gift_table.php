<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlatformGiftTable extends Migration
{
    /**
     * 可以打赏的礼物
     *
     * @return void
     */
    public function up()
    {
        Schema::create('platform_gift', function (Blueprint $table) {

            $table->increments('id');

            // 礼物名称
            $table->unsignedInteger('waitress_id');
            // 礼物图片       
            $table->unsignedInteger('uid');
            // 礼物价格         
            $table->unsignedDecimal('gift_price', 10, 2);

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
        Schema::dropIfExists('platform_gift');
    }
}
