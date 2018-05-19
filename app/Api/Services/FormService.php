<?php

namespace App\Api\Services;

use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Validator;
use App\Api\Contracts\FormContract;
use Illuminate\Validation\ValidationException;

class FormService implements FormContract
{
    /**
     * 校验表单数据
     * 
     * @param array $rules
     * @param array $formats
     * @return array
     */
    public function checkForm($rules = [], $formats = [])
    {
        $result = [
            'result' => false,
            'message' => [],
            'datas' => [],
        ];

        $rules = $this->rulesTransform($rules);

        $validator = Validator::make(Request::all(), $rules);

        if ($validator->fails()) {
            $result['message'] = $validator->messages();
            $result['validator'] = $validator;
        } else {
            foreach ($rules as $key => $value) {
                $result['datas'][$key] = Request::input($key);
            }
            $result['result'] = true;
        }
        return $result;
    }

    public function checkFormOrFail($rules = [], $formats = [])
    {
        $result = $this->checkForm($rules, $formats);
        if ($result['result'] === false) {
            throw new ValidationException($result['validator']);
        }
        return $result;
    }

    /**
     * 转化规则数组格式
     * 
     * @param  array $rules
     * @return bool|array
     */
    private function rulesTransform(array $rules)
    {
        if (count($rules) === 0 || !isset($rules[0])) {
            return $rules;
        }

        return array_reduce($rules, function ($result, $rule) {
            $result[$rule[0]] = $rule[1];
            return $result;
        });
    }
}
