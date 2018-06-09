<?php

/** 
 * 小程序登入权限校验中间件
 * 
 * file: WechatAuthMiddleware.php
 * date: 2017年11月15日
 * author: xiaojian
 */

namespace App\Http\WechatAuth\Middlewares;

use App\Http\WechatAuth\Services\AuthContract;
use Closure;

class WechatAuthMiddleware
{

    private $auth;

    public function __construct(AuthContract $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Run the request filter.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // 尝试获取权限令牌
        $id = $request->header('ng-params-one');
        $store_id = $request->header('ng-params-two');
        $token = $request->header('ng-params-three');

        // 判断头部参数是否存在
        if (isset($id, $store_id, $token) === false) {
            return response('id , token or store_id undefined', 401);
        }

        // 校验权限令牌
        if ($this->auth->checkToken($id, $store_id, $token) === false) {
            return response(json_encode('token error'), 401);
        }

        // 判断商户是否存在
        if ($this->auth->getActiveStore() === false) {
            return response(json_encode('store not found'), 401);
        }

        // 判断商户是否启用
        if ($this->auth->getActiveStore()->is_active === 0) {
            return response(json_encode('store not active'), 401);
        }

        return $next($request);
    }
}
