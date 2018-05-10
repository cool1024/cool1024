<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlatformWaitressArticleCommentTable extends Migration
{
    /**
     * 服务员动态评论/回复
     *
     * @return void
     */
    public function up()
    {
        Schema::create('platform_waitress_article_comment', function (Blueprint $table) {

            $table->increments('id');

            // 评论、回复所属文章ID
            $table->unsignedInteger('article_id');
            // 上级评论，回复(这是一个评论的ID)
            $table->string('comment_target_id', 2000);
            // 服务员ID--冗余
            $table->unsignedInteger('waitress_id');
            // 用户UID  
            $table->unsignedInteger('uid');
            // 评论、回复内容
            $table->string('comment_content', 255);
            // 类型：1-评论 2.服务员回复 3.客户回复
            $table->unsignedInteger('comment_type');

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
        Schema::dropIfExists('platform_waitress_article_comment');
    }
}
