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
        $this->app->singleton('AuthService', function () {
            return new AuthService();
        });
    }
}
