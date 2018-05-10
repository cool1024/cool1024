<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlatformStoreSalesManagerTable extends Migration
{
    /**
     * 营销汇报
     *
     * @return void
     */
    public function up()
    {
        Schema::create('platform_sales_report', function (Blueprint $table) {

            $table->increments('id');

            // 汇报的服务员ID
            $table->unsignedInteger('waitress_id');
            // 汇报对象(经理)
            $table->unsignedInteger('reciver_id');
            // 汇报日期         
            $table->unsignedTinyInteger('reported_at');
            // 业务经理出勤情况
            $table->string('manager_attendance_description', 2000);
            // 业务经理订房情况
            $table->string('manager_room_order_description', 2000);
            // 各组佳丽出勤情况
            $table->string('beautiful_girls_description', 2000);

            // 各组出勤人数
            $table->string('attendance_num_description', 2000);
            // 各组上班人数
            $table->string('work_num_description', 2000);
            // 各组订房情况
            $table->string('room_order_description', 2000);
            // 各组投诉情况
            $table->string('complain_description', 2000);
            // 其他事项
            $table->string('other_description', 2000);

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
        Schema::dropIfExists('platform_sales_report');
    }
}
