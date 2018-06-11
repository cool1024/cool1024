<?php

namespace App\Http\DevExample\Observers;

use App\Http\Store\Models\StoreUser;

class ExampleObserver
{
    /**
     * 监听创建用户事件.
     *
     * @param  \App\Http\Store\Models\StoreUser  $user
     * @return void
     */
    public function created(StoreUser $user)
    {
        var_dump('<br>observer created<br>');
        var_dump($user->toArray());
    }

    /**
     * 监听更新用户事件.
     *
     * @param  \App\Http\Store\Models\StoreUser  $user
     * @return void
     */
    public function updated(StoreUser $user)
    {
        var_dump('<br>observer updated<br>');
        var_dump($user->toArray());
    }

    /**
     * 监听删除用户事件.
     *
     * @param  \App\Http\Store\Models\StoreUser  $user
     * @return void
     */
    public function deleted(StoreUser $user)
    {
        var_dump('<br>observer deleted<br>');
        var_dump($user->toArray());
    }
}