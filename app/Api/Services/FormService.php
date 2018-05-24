<?php

namespace App\Api\Services;

use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Validator;
use App\Api\Contracts\FormContract;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;

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
                if (Request::has($key)) {
                    $result['datas'][$key] = Request::input($key);
                }
            }
            $result['result'] = true;
        }
        foreach ($formats as $key => $format) {
            if (!isset($result['datas'][$key])) continue;
            switch (gettype($format)) {
                case 'string':
                    $value = $result['datas'][$key];
                    unset($result['datas'][$key]);
                    $result['datas'][$format] = $value;
                    break;
                case 'object':
                    if (is_callable($format)) {
                        $value = $result['datas'][$key];
                        unset($result['datas'][$key]);
                        $format = $format($key, $value);
                        $result['datas'][$format] = $value;
                    }
                    break;
                default:
                    var_dump("format array type error: $key");
                    return;
            }

        }

        return $result;
    }

    /**
     * 校验表单数据,抛出异常
     * 
     * @param array $rules
     * @param array $formats
     * @return array
     */
    public function checkFormOrFail($rules = [], $formats = [])
    {
        $result = $this->checkForm($rules, $formats);
        if ($result['result'] === false) {
            throw new ValidationException($result['validator']);
        }
        return $result['datas'];
    }

    /**
     * 校验表单数据,自动转化匹配参数为小驼峰，如要匹配a_b将会变为匹配aB
     * 
     * @param array $rules
     * @param bool $reback 是否需要还原参数原始名称，默认为ture:需要
     * @return bool|array
     */
    public function camelForm($rules = [], $reback = true)
    {
        $rules = $this->rulesTransform($rules);

        $formats = [];

        foreach ($rules as $key => $value) {
            unset($rules[$key]);
            $newKey = $this->convertUnderline($key, false);
            $rules[$newKey] = $value;
            $formats[$newKey] = $key;
        };

        $formats = $reback ? $formats : [];

        return $this->checkForm($rules, $formats);
    }

    /**
     * 校验表单数据,自动转化匹配参数为小驼峰，如要匹配a_b将会变为匹配aB，抛出异常
     * 
     * @param array $rules
     * @param bool $reback 是否需要还原参数原始名称，默认为ture:需要
     * @return array
     */
    public function camelFormOrFail($rules = [], $reback = true)
    {
        $result = $this->camelForm($rules, $reback);
        if ($result['result'] === false) {
            throw new ValidationException($result['validator']);
        }
        return $result['datas'];
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

    /**
     * 下划线字符串转小驼峰
     * 
     * @param string $str
     * @return string
     */
    private function convertUnderline($str, $ucfirst = true)
    {
        $str = ucwords(str_replace('_', ' ', $str));
        $str = str_replace(' ', '', lcfirst($str));
        return $ucfirst ? ucfirst($str) : $str;
    }

    /**
     * 小驼峰字符串转下划线
     * 
     * @param string $str
     * @return string
     */
    private function convertCamelCase($str)
    {
        return strtolower(preg_replace('/((?<=[a-z])(?=[A-Z]))/', '_', $str));
    }
}