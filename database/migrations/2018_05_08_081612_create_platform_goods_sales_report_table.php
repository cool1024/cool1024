<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlatformGoodsSalesReportTable extends Migration
{
    /**
     * 出品汇报
     *
     * @return void
     */
    public function up()
    {
        Schema::create('platform_goods_sales_report', function (Blueprint $table) {
            $table->increments('id');

            // 汇报店铺--冗余
            $table->unsignedInteger('store_id');
            // 汇报人-唯一工号
            $table->unsignedInteger('repoter_id');
            // 收报人-唯一工号
            $table->unsignedInteger('reciver_id');
            // 汇报日期         
            $table->unsignedTinyInteger('reported_at');
            // 酒水销售情况
            $table->string('bear_sales_description', 2000);
            // 酒水赠送情况
            $table->string('bear_presents_description', 2000);
            // 小吃销售情况
            $table->string('snack_sales_description', 2000);
            // 小吃赠送情况
            $table->string('snack_present_description', 2000);
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
        Schema::dropIfExists('platform_goods_sales_report');
    }
}
