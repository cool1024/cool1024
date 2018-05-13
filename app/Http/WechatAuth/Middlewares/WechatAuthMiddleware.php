<?php
/*
 * 描述：登入权限校验中间件
 * 文件：AuthMiddleware.php
 * 日期：2017年11月15日
 * 作者: zhaoshiwei
 */

namespace App\Http\WechatAuth\Middlewares;

use App\Http\WechatAuth\Services\AuthContract;
use App\Api\Contracts\ApiContract;
use Closure;

class WechatAuthMiddleware
{

    private $auth;
    private $api;

    public function __construct(AuthContract $auth, ApiContract $api)
    {
        $this->auth = $auth;
        $this->api = $api;
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
        //尝试获取权限令牌
        $id = $request->header('ng-params-one');
        $store_id = $request->header('ng-params-two');
        $token = $request->header('ng-params-three');

        //判断头部参数是否存在
        if (isset($id, $store_id, $token) === false) {
            return response('id or token undefined', 401);
        }

        //校验权限令牌
        if ($this->auth->checkToken($id, $store_id, $token) === false) {
            return response(json_encode('token error'), 401);
        }

        return $next($request);
    }
}
