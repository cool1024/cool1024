<?php

namespace App\Api\BaseClass;

use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{

    protected $form;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->form = app('App\Api\Contracts\FormContract');
    }
}