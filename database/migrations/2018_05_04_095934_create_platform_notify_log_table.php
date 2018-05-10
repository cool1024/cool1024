<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlatformNotifyLogTable extends Migration
{
    /**
     * 服务通知
     *
     * @return void
     */
    public function up()
    {
        Schema::create('platform_notify_log', function (Blueprint $table) {
            $table->increments('id');

            // 通知来源店铺
            $table->unsignedInteger('store_id');
            // 通知对象-这个是uid
            $table->unsignedInteger('receiver_id');
            // 通知标题
            $table->string('notify_title', 45);
            // 通知图片
            $table->string('notify_thumb', 100);
            // 通知链接
            $table->string('notify_url', 100);            
            // 通知内容
            $table->string('notify_content', 255);
            // 通知类型
            $table->unsignedTinyInteger('notify_type');
            // 通知状态 0.等待通知 1.已经发送 2.已经阅读
            $table->unsignedTinyInteger('notify_status');

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
        Schema::dropIfExists('platform_notify_log');
    }
}
