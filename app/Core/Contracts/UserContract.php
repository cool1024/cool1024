<?php

namespace App\Core\Contracts;

interface UserContract
{
    /**
     * 注入用户
     * 
     * @param Model|any $user 用户模型或其他需要的参数
     */
    public function init($user);

    /**
     * 获取用户的ORM实例
     * 
     * @return Model
     */
    public function user();

    /**
     * 获取用户的详细信息
     * 
     * @return array
     */
    public function detail();
}
