<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlatformUserAppointmentTable extends Migration
{
    /**
     * 用户预约记录，通常用户在一个KTV选择一个包厢规格就可以预约
     * 预约的处理目前为线下，经理自己跟进，所以这里的预约只做记录作用
     * 所有预约中的记录都会被推送给负责这个KTV的经理
     * 
     * @return void
     */
    public function up()
    {
        Schema::create('platform_user_appointment', function (Blueprint $table) {
            
            // 预约唯一编号
            $table->increments('id');
            // 预约所属店铺--冗余
            $table->unsignedInteger('store_id');
            // 预约用户           
            $table->unsignedInteger('uid');
            // 预约包厢规格
            $table->unsignedInteger('room_specifications_id');
            // 预约使用时间--什么时候要来
            $table->date('appointment_date');
            // 预约使用时长--无实际意义，只是做一个补充而已，由经理自己线下处理
            $table->string('appointment_time_range', 45);
            // 预约受理员工--work_id
            $table->unsignedInteger('deal_work_id');
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
        Schema::dropIfExists('platform_user_appointment');
    }
}
