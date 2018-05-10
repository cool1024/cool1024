<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlatformActiveGoodsOrderTable extends Migration
{
    /**
     * 活动商品订单
     *
     * @return void
     */
    public function up()
    {
        Schema::create('platform_active_goods_order', function (Blueprint $table) {

            // 订单唯一编号
            $table->increments('id');
            // 订单号
            $table->string('order_sn', 45);            
            // 订单所属店铺--冗余
            $table->unsignedInteger('store_id');
            // 下单用户           
            $table->unsignedInteger('uid');
            // 包间号           
            $table->string('room_no', 45);
            // 订单商品
            $table->unsignedInteger('active_goods_id');
            // 商品名称
            $table->unsignedInteger('active_goods_name');
            // 商品图
            $table->unsignedInteger('active_goods_thumb');
            // 商品数量
            $table->unsignedInteger('active_goods_num');
            // 商品单价-下单时价格
            $table->unsignedInteger('active_goods_price');
            // 实际支付金额
            $table->unsignedDecimal('order_pay', 10, 2);
             // 订单支付金额
            $table->unsignedDecimal('order_price', 10, 2);
            // 订单状态 0-订单关闭 1-待支付 2-已支付 3-完成
            $table->unsignedTinyInteger('order_status');
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
        Schema::dropIfExists('platform_active_goods_order');
    }
}
