<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlatformLeaveMessageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('platform_leave_message', function (Blueprint $table) {

            // 留言唯一编号
            $table->increments('id');
            // 留言所属店铺
            $table->unsignedInteger('store_id');
            // 留言来源对象-这是uid
            $table->unsignedInteger('from_id');
            // 留言通知对象-这是uid
            $table->string('to_id', 45);      
            // 留言内容
            $table->string('leave_message_content', 500);
            // 留言状态 0.未读 1.已读
            $table->unsignedTinyInteger('leave_message_status');
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
        Schema::dropIfExists('platform_leave_message');
    }
}
