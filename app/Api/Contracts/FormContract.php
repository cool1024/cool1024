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
}
