<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlatformWaitressCustomerTable extends Migration
{
    /**
     * 服务员客户列表
     *
     * @return void
     */
    public function up()
    {
        Schema::create('platform_waitress_customer', function (Blueprint $table) {

            $table->increments('id');

            // 客户所属服务员
            $table->unsignedInteger('waitress_id');
            // 客户UID         
            $table->unsignedInteger('uid');
            // 客户姓名         
            $table->string('customer_name', 45);
            // 客户电话
            $table->string('customer_phone', 45);
            // 客户微信号
            $table->string('customer_wechat', 45);
            // 客户生日
            $table->date('customer_birthday');
            // 客户标签
            $table->string('customer_labels', 1000);

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
        Schema::dropIfExists('platform_waitress_customer');
    }
}
