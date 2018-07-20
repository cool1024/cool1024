<?php

/**
 * 权限校验中间件
 * @author xiaojian
 * @file AuthMiddleware.php
 * @date 2018-5-29
 */

namespace App\Http\ManagerApi\Middlewares;

use Closure;
use Symfony\Component\HttpFoundation\ParameterBag;
use App\Api\Contracts\FormContract;
use App\Http\ManagerApi\Classes\Token;
use App\Http\ManagerApi\Classes\User;

class AuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  array  ...$attributes
     * @return mixed
     */
    public function handle($request, Closure $next, ...$attributes)
    {
        $id = $request->header('ng-params-one');
        $token = $request->header('ng-params-two');
        $platform = $request->header('ng-params-three');

        // 令牌判定
        if (!isset($id, $token, $platform)) {
            return abort(401, 'token lost');
        }

        // 校验令牌
        $tokenService = new Token();
        $tokenService->init([
            'id' => $id,
            'token' => $token,
            'platform' => $platform,
        ]);
        if ($tokenService->checkToken() === false) {
            return abort(401, 'token error');
        }

        // 获取用户
        $auth = app('App\Core\Contracts\AuthContract');
        $userService = new User();
        $userService->init($tokenService->getToken()->uid);

        // 校验用户状态
        if ($userService->user()->is_active !== 1) {
            return abort(403, '用户账户被停用');
        }

        // 权限校验
        if (isset($attributes)) {

            $paramsCount = count($attributes);

            // 只有一个额外参数，默认为权限关键词
            if ($paramsCount === 1
                && false === $userService->hasPermission([
                'permission_key' => array_first($attributes)
            ])) {
                return abort(403, 'permission denied');
            }

            // 有两个额外参数，那么第一个是参数类型（permission,role...）,第二个参数为实际值
            if ($paramsCount === 2) {
                switch (array_first($attributes)) {
                    case 'permission':
                        {
                            if (false === $userService->hasPermission([
                                'permission_key' => array_last($attributes)
                            ])) {
                                return abort(403, 'permission denied');
                            }
                            break;
                        }
                    case 'role':
                        {
                            if (array_last($attributes) != $userService->user()->role_id) {
                                return abort(403, 'role error');
                            }
                            break;
                        }
                    default:
                        {
                            return abort(200, '中间件校验参数格式错误');
                        }
                }
            }
        }

        // 初始化Auth服务
        $auth->initUserService($userService);
        $auth->initTokenService($tokenService);

        return $next($request);
    }
}