<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlatformStoreSalesManagerTable extends Migration
{
    /**
     * 服务员收支记录，提现，被打赏都会记录
     *
     * @return void
     */
    public function up()
    {
        Schema::create('platform_waitress_money_log', function (Blueprint $table) {

            $table->increments('id');

            // 记录所属服务员
            $table->unsignedInteger('waitress_id');
            // 记录类型：0-收入、1-提现         
            $table->unsignedTinyInteger('log_type');
            // 变动金额         
            $table->unsignedDecimal('log_money', 10, 2);
            // 状态,提现才有这个状态 0.拒绝 1.申请中 2.完成       
            $table->string('log_status', 45);

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
        Schema::dropIfExists('platform_waitress_money_log');
    }
}
