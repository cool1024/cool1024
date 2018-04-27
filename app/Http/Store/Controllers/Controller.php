<?php

namespace App\Http\Store\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use App\Api\Contracts\ApiContract;
use App\Api\Contracts\FileContract;

class Controller extends BaseController
{

    protected $api;
    protected $file;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(ApiContract $api, FileContract $file)
    {
        $this->api = $api;
        $this->file = $file;
    }
}
