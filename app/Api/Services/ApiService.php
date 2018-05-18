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

    public function camelCaseParams($params = [], $exp = [])
    {
        foreach ($params as $key => $param) {
            $params[$key] = $this->convertUnderline($param, false);
        }

        foreach ($exp as $key => $param) {
            $exp[$key] = $this->convertUnderline($param, false);
        }

        $params = $this->checkParams($params, $exp);
        $temp = [];

        foreach ($params as $key => $value) {
            $temp_key = strtolower(preg_replace('/((?<=[a-z])(?=[A-Z]))/', '_', $key));
            $temp[$temp_key] = $value;
        }
        return $temp;
    }

    public function checkParams($params = [], $exp = [], $formate = [], $message = [])
    {

        $params = $this->getParams($params, $exp, $formate, $message);

        if ($params['result']) {
            return $params['datas'];
        } else {
            abort(201, json_encode($params));
            return;
        }
    }

    private function convertUnderline($str, $ucfirst = true)
    {
        $str = ucwords(str_replace('_', ' ', $str));
        $str = str_replace(' ', '', lcfirst($str));
        return $ucfirst ? ucfirst($str) : $str;
    }

    public function createMessage($create_obj)
    {
        return $this->create_message($create_obj);
    }

    public function getMessage($datas = '')
    {
        return $this->message(true, 'get datas success', $datas);
    }

    public function saveMessage($message)
    {
        return $this->message(true, 'get datas success');
    }

    public function deleteMessage($result)
    {
        return $this->delete_message($result);
    }

    public function updateMessage($result)
    {
        return $this->success(empty($result) ? '没有需要更新的数据～' : '数据更新成功～');
    }

    public function searchMessage($result)
    {
        return $this->paginate($result);
    }
}
