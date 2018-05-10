<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlatformStoreSalesManagerTable extends Migration
{
    /**
     * 服务员动态
     *
     * @return void
     */
    public function up()
    {
        Schema::create('platform_waitress_article', function (Blueprint $table) {

            $table->increments('id');

            // 服务员ID
            $table->unsignedInteger('waitress_id');
             // 动态内容        
            $table->string('article_content', 2000);
             // 动态图片
            $table->string('article_images', 2000);

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
        Schema::dropIfExists('platform_waitress_article');
    }
}
