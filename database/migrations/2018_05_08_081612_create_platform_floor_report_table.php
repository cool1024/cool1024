<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlatformStoreSalesManagerTable extends Migration
{
    /**
     * 楼面汇报
     *
     * @return void
     */
    public function up()
    {
        Schema::create('platform_floor_report', function (Blueprint $table) {

            $table->increments('id');

            // 汇报的服务员ID
            $table->unsignedInteger('waitress_id');
            // 汇报对象(经理)
            $table->unsignedInteger('reciver_id');
            // 汇报日期         
            $table->unsignedTinyInteger('reported_at');
            // 应到人数-少爷
            $table->unsignedInteger('signorino_exp_num');
            // 实到人数-少爷
            $table->unsignedInteger('signorino_rel_num');
            // 看房人数-少爷      
            $table->unsignedInteger('signorino_room_num');
            // 应到人数-公主
            $table->unsignedInteger('princess_exp_num');
            // 实到人数-公主
            $table->unsignedInteger('princess_rel_num');
            // 看房人数-公主      
            $table->unsignedInteger('princess_room_num');
            // 楼面部事项
            $table->string('floor_description', 2000);
            // 营销部事项     
            $table->string('sales_description', 2000);
            // 今日工作总结     
            $table->string('work_description', 2000);

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
        Schema::dropIfExists('platform_floor_report');
    }
}
