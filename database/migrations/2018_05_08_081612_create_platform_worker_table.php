<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlatformStoreSalesManagerTable extends Migration
{
    /**
     * 平台员工表（老板，经理，服务员都需要在这个表中有一个唯一员工号，默认就是id）
     *
     * @return void
     */
    public function up()
    {
        Schema::create('platform_worker', function (Blueprint $table) {

            // 唯一员工号
            $table->increments('id');
            // 所属店铺
            $table->unsignedInteger('store_id');
            // 员工角色（boss,manager,server）
            $table->enum('worker_role', ['boss', 'manager', 'server']);
            // 开通权限       
            $table->string('worker_permissions', 1000);
            // 是否启用员工         
            $table->unsignedTinyInteger('is_active');

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
        Schema::dropIfExists('platform_worker');
    }
}
