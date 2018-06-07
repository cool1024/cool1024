<?php

namespace App\Api\Services;

use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Validator;
use App\Api\Contracts\FormContract;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;

class FormService implements FormContract
{

    private $successMessageStr = '成功';
    private $failMessageStr = '失败';
    private $createMessageStr = '创建';
    private $saveMessageStr = '保存';
    private $deleteMessageStr = '删除';
    private $updateMessageStr = '更新';

    /**
     * 数据创建结果响应
     * 
     * @param Model 创建返回的ORM实例
     * @param string $name 模型名称（如‘商品’）
     * @return JsonResponse
     */
    public function createMessage($object, $name = '')
    {
        $result = isset($object);
        $message = $this->createMessageStr . $name . $this->message($result);
        $apiData = $this->apiData($result, $message, $object);
        return $this->jsonResponse($apiData);
    }

    /**
     * 数据保存结果响应
     * 
     * @param bool $saveResult 保存结果
     * @param string $name 模型名称（如‘商品’）
     * @return JsonResponse
     */
    public function saveMessage($saveResult, $name = '')
    {
        $result = $saveResult;
        $message = $this->saveMessageStr . $name . $this->message($result);
        $apiData = $this->apiData($result, $message, []);
        return $this->jsonResponse($apiData);
    }

    /**
     * 数据更新结果响应
     * 
     * @param int|bool $updateResult 受影响的行数|更新结果
     * @param string $name 模型名称（如‘商品’）
     * @return JsonResponse
     */
    public function updateMessage($updateResult, $name = '')
    {
        $result = !empty($updateResult);
        $message = $this->updateMessageStr . $name . $this->message($result);
        $apiData = $this->apiData($result, $message, []);
        return $this->jsonResponse($apiData);
    }

    /**
     * 数据删除结果响应
     * 
     * @param bool|null $deleteResult 删除结果|null
     * @param string $name 模型名称（如‘商品’）
     * @return JsonResponse
     */
    public function deleteMessage($deleteResult, $name = '')
    {
        $result = !empty($deleteResult);
        $message = $this->deleteMessageStr . $name . $this->message($result);
        $apiData = $this->apiData($result, $message, []);
        return $this->jsonResponse($apiData);
    }

    /**
     * 获取一个数据消息
     * 
     * @param mixed $datas 获取的数据
     * @return JsonResponse
     */
    public function getMessage($datas, $message = 'get datas success')
    {
        return $this->datas($datas, $message);
    }

    /**
     * 获取一个错误消息
     * 
     * @param string $message
     * @return JsonResponse
     */
    public function error($message = 'error')
    {
        $apiData = $this->apiData(false, $message, null);
        return $this->jsonResponse($apiData);
    }

    /**
     * 获取一个成功消息
     * 
     * @param string $message
     * @return JsonResponse
     */
    public function success($message = 'success')
    {
        $apiData = $this->apiData(true, $message, null);
        return $this->jsonResponse($apiData);
    }

    /**
     * 获取一个数据消息
     * 
     * @param string $message
     * @return JsonResponse
     */
    public function datas($datas, $message = 'get datas success')
    {
        $apiData = $this->apiData(true, $message, $datas);
        return $this->jsonResponse($apiData);
    }

    /**
     * 创建一个JsonResponse实例
     * 
     * @param array $apiData
     * @return JsonResponse
     */
    private function jsonResponse($apiData)
    {
        return response()->json($apiData);
    }

    /**
     * 创建一个响应数据
     * 
     * @param bool $result
     * @param string $message
     * @param any $datas
     */
    private function apiData($result, $message, $datas)
    {
        return [
            'result' => $result,
            'message' => $message,
            'datas' => $datas,
        ];
    }
    private function message($result)
    {
        return $result ? $this->successMessageStr : $this->failMessageStr;
    }

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
     * @param array $min 最少参数配置
     * @return array
     */
    public function checkFormOrFail($rules = [], $formats = [], $min = [0, 'params must no less than 0'])
    {
        $result = $this->checkForm($rules, $formats);
        if ($result['result'] === false) {
            throw new ValidationException($result['validator']);
        } else if (count($result['datas']) < $min[0]) {
            $result['result'] = false;
            $result['message'] = $min[1];
            abort(422, json_encode($result));
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
     * 获取所有表单数据
     * @return array
     */
    public function allParams()
    {
        return Request::all();
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