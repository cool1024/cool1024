<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlatformMessageLogTable extends Migration
{
    /**
     * 平台公告
     *
     * @return void
     */
    public function up()
    {
        Schema::create('platform_message_log', function (Blueprint $table) {

            $table->increments('id');

            // 发布的平台管理员id
            $table->unsignedInteger('platform_manager_id');
            // 消息状态 0.草稿 1.已经发布
            $table->unsignedTinyInteger('message_status');
            // 消息标题
            $table->string('message_title', 45);
            // 消息图片
            $table->string('message_thumb', 100);
            // 消息链接
            $table->string('message_url', 100);            
            // 消息内容
            $table->string('message_content', 255);

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
        Schema::dropIfExists('platform_message_log');
    }
}
