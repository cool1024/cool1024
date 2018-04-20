<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccessCompanyManager extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('access_company_manager', function (Blueprint $table) {
            $table->increments('id');
            $table->string('company_manager_account', 30);
            $table->string('company_manager_mobile', 20);
            $table->string('company_manager_email', 100);
            $table->string('company_name', 100);
            $table->string('company_description', 100);
            $table->string('company_logo', 200);
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
        Schema::dropIfExists('access_company_manager');
    }
}
