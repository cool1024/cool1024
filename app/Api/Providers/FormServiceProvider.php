<?php

namespace App\Api\Providers;

use Illuminate\Support\ServiceProvider;

class FormServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('App\Api\Contracts\FormContract', 'App\Api\Services\FormService');
    }
}
