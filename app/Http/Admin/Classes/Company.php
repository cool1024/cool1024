<?php

namespace App\Http\Admin\Controllers;

use App\Http\Admin\Models\AccessCompanyManager;

class Company
{

    private $params;

    private $password;

    public function __construct($params)
    {
        $this->params = $params;
        if (isset($this->params['password'])) {
            $this->password = $params['password'];
            unset($this->params['password']);
        }
    }

    public function save()
    {
        return AccessCompanyManager::create($this->params);
    }
}
