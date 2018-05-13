<?php

namespace App\Http\WechatAuth\Services;

use Illuminate\Support\ServiceProvider;
use App\Http\WechatAuth\Services\AuthService;

class AuthServiceProvider extends ServiceProvider
{

    private $service;

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('App\Http\WechatAuth\Services\AuthContract', function () {
            return new AuthService();
        });
        $this->app->singleton('App\Http\WechatAuth\Services\WechatContract', function () {
            return new WechatService();
        });
    }
}
