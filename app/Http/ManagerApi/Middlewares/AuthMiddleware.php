<?php
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
            abort(401, 'token error');
        }

        // 获取用户
        $auth = app('App\Core\Contracts\AuthContract');
        $userService = new User();
        $userService->init($tokenService->getToken()->uid);

        // 初始化Auth服务
        $auth->initUserService($userService);
        $auth->initTokenService($tokenService);

        return $next($request);
    }
}