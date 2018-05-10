<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccessOperateLog extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('access_operate_log', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('operate_platform_manager_id');
            $table->unsignedInteger('operate_company_manager_id');
            $table->string('operate_table_name', 30);
            $table->unsignedTinyInteger('operate_action_type');
            $table->text('operate_table_datas');
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
        Schema::dropIfExists('access_operate_log');
    }
}
