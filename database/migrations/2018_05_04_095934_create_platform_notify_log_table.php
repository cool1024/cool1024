<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlatformNotifyLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('platform_notify_log', function (Blueprint $table) {
            $table->increments('id');

            // 发布的平台管理员id
            $table->unsignedInteger('platform_manager_id');
            // 通知标题
            $table->string('notify_title', 45);
            // 通知图片
            $table->string('notify_thumb', 45);
            // 通知链接
            $table->string('notify_url', 45);            
            // 通知内容
            $table->string('notify_content', 255);
            // 通知范围
            $table->string('notify_where', 1000);
            // 通知类型 0.默认通知 1.模板消息 2.其他消息
            $table->unsignedTinyInteger('notify_type');
            // 通知状态 0.草稿 1.已经发布
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
