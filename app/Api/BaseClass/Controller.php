<?php

namespace App\Api\BaseClass;

use Laravel\Lumen\Routing\Controller as BaseController;
use App\Api\Contracts\FormContract;

class Controller extends BaseController
{

    protected $form;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(FormContract $form)
    {
        $this->form = $form;
    }
}