<?php

namespace App\Http\ManagerApi\Classes;

use App\Core\Contracts\UserContract;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\ManagerApi\Models\SystemUser;

class User implements UserContract
{

    private $userModel;

    /**
     * 注入用户
     * @param mixed $userParams 用户模型或其他需要的参数
     */
    public function init($userParams)
    {
        if ($userParams instanceof Model) {
            $this->userModel = $userParams;
        } else if (gettype($userParams) === 'integer') {
            $this->userModel = SystemUser::findOrFail($userParams);
        } else {
            $this->userModel = SystemUser::where($userParams)->first();
            if (!isset($this->userModel)) {
                throw new ModelNotFoundException('不存在的用户');
            }
        }
    }

    /**
     * 获取用户的ORM实例
     * 
     * @return Model
     */
    public function user()
    {
        return $this->userModel;
    }

    /**
     * 获取用户的详细信息
     * 
     * @return array
     */
    public function detail()
    {
        return $this->userModel;
    }
}