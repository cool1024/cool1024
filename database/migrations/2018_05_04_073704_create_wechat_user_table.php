<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWechatUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wechat_user', function (Blueprint $table) {
            $table->increments('id');
            $table->string('openid', 45);
            $table->string('realname', 45);
            $table->string('mobile', 45);
            $table->string('nickname', 45);
            $table->string('headimgurl', 255);
            $table->string('address', 45);
            $table->string('sex', 45);
            $table->string('city', 45);
            $table->string('country', 45);
            $table->string('province', 45);
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
        Schema::dropIfExists('wechat_user');
    }
}
