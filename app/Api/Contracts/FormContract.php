<?php

namespace App\Api\Contracts;

interface FormContract
{
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
