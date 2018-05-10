<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlatformStoreSalesManagerTable extends Migration
{
    /**
     * 客户标签（收集一些服务员添加的标签，方便快速使用）
     *
     * @return void
     */
    public function up()
    {
        Schema::create('platform_customer_labe', function (Blueprint $table) {

            // 标签唯一编号
            $table->increments('id');
            // 标签名称
            $table->unsignedInteger('label_name');
            // 标签使用量-使用率高的优先使用
            $table->unsignedInteger('label_total');

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
        Schema::dropIfExists('platform_customer_labe');
    }
}
