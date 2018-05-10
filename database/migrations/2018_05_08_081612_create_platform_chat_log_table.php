<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlatformChatLogTable extends Migration
{
    /**
     * 员工内部聊天记录
     *
     * @return void
     */
    public function up()
    {
        Schema::create('platform_chat_log', function (Blueprint $table) {

            $table->increments('id');

            // 消息所属店铺、KTV
            $table->unsignedInteger('store_id');            
            // 发送人-work_id
            $table->unsignedInteger('reported_id');
            // 接收人-work_id
            $table->unsignedInteger('reciver_id');
            // 消息类型 0-文本 1-链接 2-图像 3-语音
            $table->string('chat_type', 45);
            // 消息内容
            $table->string('chat_content', 1000);

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
        Schema::dropIfExists('platform_chat_log');
    }
}
