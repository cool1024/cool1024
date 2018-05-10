<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlatformStoreRoomTable extends Migration
{
    /**
     * KTV 包厢/间规格，一般为大包，中包，小包
     *
     * @return void
     */
    public function up()
    {
        Schema::create('platform_store_room_specifications', function (Blueprint $table) {

            // 规格唯一编号
            $table->increments('id');
            // 包间规格所属店铺
            $table->unsignedInteger('store_id');
            // 包间规格名称
            $table->string('room_specifications_name', 200);
            // 此规格默认人数
            $table->unsignedTinyInteger('room_people_num');
            // 其他描述信息
            $table->string('room_specifications_description', 255);
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
        Schema::dropIfExists('platform_store_room_specifications');
    }
}
