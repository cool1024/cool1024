<?php

namespace App\Http\DevExample\Providers;

use Illuminate\Support\ServiceProvider;
use App\Http\Store\Models\StoreUser;
use App\Http\DevExample\Observers\ExampleObserver;

class OrmEventProvider extends ServiceProvider
{
    /**
     * 挂载ORM事件
     */
    public function boot()
    {

        // 店铺用户信息更新后的钩子事件
        StoreUser::created(function (StoreUser $user) {
            var_dump('<br>created<br>');
            var_dump($user->toArray());
        });

        // 店铺用户被更新后的钩子事件
        StoreUser::updated(function (StoreUser $user) {
            var_dump('<br>updated<br>');
            var_dump($user->toArray());
        });

         // 店铺用户被删除后的钩子事件
        StoreUser::deleted(function (StoreUser $user) {
            var_dump('<br>deleted<br>');
            var_dump($user->toArray());
        });

        // 注册观察者
        StoreUser::observe(ExampleObserver::class);
    }
}
