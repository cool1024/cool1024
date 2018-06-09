<?php

/** 
 * 小程中间件,这个中间件会载入小程序的配置信息，并初始化小程序微信服务
 * 
 * file: WechatAuthMiddleware.php
 * date: 2017年11月15日
 * author: xiaojian
 */

namespace App\Http\WechatAuth\Middlewares;

use App\Http\WechatAuth\Services\AuthContract;
use App\Api\Contracts\ApiContract;
use Closure;
use App\Http\WechatAuth\Services\WechatContract;

class SmallRoutineMiddleware
{

    private $auth;

    public function __construct(AuthContract $auth, WechatContract $wechat)
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
        // 判断小程序是否存在
        $small_routine = $this->auth->getActiveSmallRoutine();
        if ($small_routine === false) {
            return response(json_encode('samll routine not found'), 401);
        }

        // 初始化小程序服务
        $this->wechat->loadConfig($small_routine->config);

        return $next($request);
    }
}
