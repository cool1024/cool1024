<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlatformStoreActiveGoodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('platform_store_active_goods', function (Blueprint $table) {

            // 活动商品唯一编号
            $table->increments('id');
            // 商品所属店铺
            $table->unsignedInteger('store_id');
            // 商品名称
            $table->string('goods_name', 200);
            // 商品缩略图
            $table->string('goods_thumb', 200);
            // 商品展示图
            $table->string('goods_images', 1000);
            // 商品价格
            $table->unsignedDecimal('goods_price', 10, 2);
            // 商品总数量--库存
            $table->unsignedInteger('goods_stock');
            // 商品销售数量
            $table->unsignedInteger('goods_sales');
            // 开始时间
            $table->date('opened_at');
            // 结束时间
            $table->date('closed_at');

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
        Schema::dropIfExists('platform_store_active_goods');
    }
}
