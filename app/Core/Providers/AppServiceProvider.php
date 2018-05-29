<?php

namespace App\Core\Providers;

use Illuminate\Support\ServiceProvider;
use App\Core\Services\AuthService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('App\Core\Contracts\AuthContract', function () {
            return new AuthService();
        });
    }
}
