<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccessPlatformManager extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('access_platform_manager', function (Blueprint $table) {
            $table->increments('id');
            $table->string('platform_manager_account', 30);
            $table->string('platform_manager_mobile', 20);
            $table->string('platform_manager_email', 100);
            $table->unsignedTinyInteger('is_active');
            $table->string('password', 255);
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
        Schema::dropIfExists('create_access_operate_log');
    }
}
