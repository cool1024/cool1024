<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlatformStoreSalesManagerTable extends Migration
{
    /**
     * 客户消费记录，由服务员添加
     *
     * @return void
     */
    public function up()
    {
        Schema::create('platform_customer_consum', function (Blueprint $table) {

            $table->increments('id');

            // 创建者（员工）
            $table->unsignedInteger('work_id');
            // 客户唯一编号      
            $table->unsignedInteger('uid');
            // 客户类型 0-副 1-主        
            $table->unsignedTinyInteger('customer_type');
            // 订房人姓名         
            $table->string('room_waitress_name', 45);
            // 酒促姓名
            $table->string('beer_waitress_name', 45);
            // 服务费
            $table->unsignedDecimal('waitress_price', 10, 2);
            // 房间号
            $table->date('room_no');
            // 消费时间
            $table->date('customer_birthday');

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
        Schema::dropIfExists('platform_customer_consum');
    }
}
