<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlatformCashReportTable extends Migration
{
    /**
     * 收银记录
     *
     * @return void
     */
    public function up()
    {
        Schema::create('platform_cash_report', function (Blueprint $table) {

            $table->increments('id');

            // 汇报所属店铺
            $table->unsignedInteger('store_id');
            // 汇报人-work_id
            $table->unsignedInteger('reported_id');
            // 接受人-work_id
            $table->unsignedInteger('reciver_id');
            // 汇报日期         
            $table->date('reported_at');
            // 开房数量         
            $table->unsignedInteger('room_total');
            // 总营业额         
            $table->unsignedDecimal('all_total', 10, 2);
            // 现金收入      
            $table->unsignedDecimal('cash_total', 10, 2);
            // 银行卡收入      
            $table->unsignedDecimal('credit_total', 10, 2);
            // 微信收入      
            $table->unsignedDecimal('wecaht_total', 10, 2);
            // 支付宝收入      
            $table->unsignedDecimal('alipay_total', 10, 2);
            // 会员卡收入      
            $table->unsignedDecimal('vip_card_total', 10, 2);
            // 挂账    
            $table->unsignedDecimal('no_pay', 10, 2);
            // 免单金额      
            $table->unsignedDecimal('free_pay', 10, 2);
            // 赠送      
            $table->unsignedDecimal('present_pay', 10, 2);
            // 各部门业绩统计     
            $table->string('total_description', 2000);

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
        Schema::dropIfExists('platform_cash_report');
    }
}
