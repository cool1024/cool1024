<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlatformStoreSalesManagerTable extends Migration
{
    /**
     * KTV/店铺经理表
     *
     * @return void
     */
    public function up()
    {
        Schema::create('platform_store_sales_manager', function (Blueprint $table) {
            $table->increments('id');

            // 经理管理的店铺
            $table->unsignedInteger('store_id');
            // 经理名称、姓名           
            $table->string('manager_name');
            // 经理联系方式
            $table->string('manager_phone', 45);

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
        Schema::dropIfExists('platform_store_sales_manager');
    }
}
