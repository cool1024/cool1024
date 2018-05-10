<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlatformNotifyTypeTable extends Migration
{
    /**
     * 通知类型
     *
     * @return void
     */
    public function up()
    {
        Schema::create('platform_notify_type', function (Blueprint $table) {

            $table->increments('id');

            // 通知类型名称
            $table->unsignedInteger('notify_type_name');
            // 通知触发条件
            $table->string('notify_where',1000);

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
        Schema::dropIfExists('platform_notify_type');
    }
}
