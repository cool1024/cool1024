<?php

namespace App\Api\Services;

use App\Api\Contracts\ApiContract;
use App\Api\Traits\ApiTrait;

class ApiService implements ApiContract
{
    use ApiTrait;

    public function __construct()
    {
    }

    function checkParams($params = [], $exp = [], $formate = [], $message = [])
    {

        $params = $this->getParams($params, $exp, $formate, $message);

        if ($params['result']) {
            return $params['datas'];
        } else {
            abort(201, json_encode($params));
        }
    }

    public function createMessage($create_obj)
    {
        return $this->create_message($create_obj);
    }

    public function getMessage($datas)
    {
        return $this->message(true, 'get datas success', $datas);
    }

    public function deleteMessage($result)
    {
        return $this->delete_message($result);
    }
}
