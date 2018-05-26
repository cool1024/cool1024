<?php

namespace App\Api\Contracts;

interface FormContract
{

    /**
     * 数据创建结果响应
     * 
     * @param Model 创建返回的ORM实例
     * @param string $name 模型名称（如‘商品’）
     * @return JsonResponse
     */
    public function createMessage($object, $name = '');

    /**
     * 数据保存结果响应
     * 
     * @param bool $saveResult 保存结果
     * @param string $name 模型名称（如‘商品’）
     * @return JsonResponse
     */
    public function saveMessage($saveResult, $name = '');

    /**
     * 数据更新结果响应
     * 
     * @param int|bool $updateResult 受影响的行数|更新结果
     * @param string $name 模型名称（如‘商品’）
     * @return JsonResponse
     */
    public function updateMessage($updateResult, $name = '');

    /**
     * 数据删除结果响应
     * 
     * @param bool|null $deleteResult 删除结果|null
     * @param string $name 模型名称（如‘商品’）
     * @return JsonResponse
     */
    public function deleteMessage($deleteResult, $name = '');

    /**
     * 获取一个数据消息
     * 
     * @param mixed $datas 获取的数据
     * @return JsonResponse
     */
    public function getMessage($datas, $message = 'get datas success');

    /**
     * 获取一个错误消息
     * 
     * @param string $message
     * @return JsonResponse
     */
    public function error($message = 'error');

    /**
     * 获取一个成功消息
     * 
     * @param string $message
     * @return JsonResponse
     */
    public function success($message = 'success');

    /**
     * 获取一个数据消息
     * 
     * @param string $message
     * @return JsonResponse
     */
    public function datas($datas, $message = 'get datas success');

    /**
     * 校验表单数据
     * 
     * @param array $rules
     * @param array $formats
     * @return bool|array
     */
    public function checkForm($rules = [], $formats = []);

    /**
     * 校验表单数据,抛出异常
     * 
     * @param array $rules
     * @param array $formats
     * @return bool|array
     */
    public function checkFormOrFail($rules = [], $formats = []);

    /**
     * 校验表单数据,自动转化匹配参数为小驼峰，如要匹配a_b将会变为匹配aB
     * 
     * @param array $rules
     * @param bool $reback 是否需要还原参数原始名称，默认为ture:需要
     * @return bool|array
     */
    public function camelForm($rules = [], $reback = true);

    /**
     * 校验表单数据,自动转化匹配参数为小驼峰，如要匹配a_b将会变为匹配aB，抛出异常
     * 
     * @param array $rules
     * @param bool $reback 是否需要还原参数原始名称，默认为ture:需要
     * @return array
     */
    public function camelFormOrFail($rules = [], $reback = true);
}
