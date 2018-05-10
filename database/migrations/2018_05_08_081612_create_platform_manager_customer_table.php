<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlatformManagerCustomerTable extends Migration
{
    /**
     * 经理的客户列表
     * 经理的客户都是来源与服务员分享、提交而来，自己本身不添加
     * 
     * @return void
     */
    public function up()
    {
        Schema::create('platform_manager_customer', function (Blueprint $table) {

            $table->increments('id');

            // 客户所属经理
            $table->unsignedInteger('manager_id');
            // 客户来源服务员
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
            $table->string('customer_labels',1000);

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
