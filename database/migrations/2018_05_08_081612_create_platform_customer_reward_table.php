<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlatformCustomerRewardTable extends Migration
{
    /**
     * 客户打赏记录
     *
     * @return void
     */
    public function up()
    {
        Schema::create('platform_customer_reward', function (Blueprint $table) {

            $table->increments('id');

            // 打赏的服务员ID
            $table->unsignedInteger('waitress_id');
            // 客户UID         
            $table->unsignedInteger('uid');
            // 打赏礼物ID         
            $table->unsignedInteger('gift_id', 45);
            // 评分一般为数字1-5（多少颗星星）
            $table->unsignedTinyInteger('customer_labels', 1000);

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
        Schema::dropIfExists('platform_customer_reward');
    }
}
