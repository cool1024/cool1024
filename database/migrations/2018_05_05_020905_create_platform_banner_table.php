<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlatformBannerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('platform_banner', function (Blueprint $table) {
            $table->increments('id');

            // 幻灯片所属商户
            $table->unsignedInteger('store_id');
            // 幻灯片图片链接
            $table->string('banner_image', 255);      
            // 幻灯片目标地址
            $table->string('banner_target', 45);
            // 幻灯片目标类型 0.链接 1.小程序页面 2.app入口
            $table->unsignedTinyInteger('banner_target_type');
            // 幻灯片尺寸信息 width,height,如100,200
            $table->string('banner_size', 45);
             // 排序级别 0最小----数字越大级别越高
            $table->unsignedTinyInteger('banner_level');

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
        Schema::dropIfExists('platform_banner');
    }
}
