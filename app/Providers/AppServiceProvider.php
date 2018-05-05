<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('App\Providers\TestConcat', 'App\Providers\MyService');
    }
}

interface TestConcat
{
    function setData($data);

    function getData();
}

class MyService
{
    private $data;

    function setData($data)
    {
        $this->data = $data;
    }

    function getData()
    {
        return $data;
    }
}
