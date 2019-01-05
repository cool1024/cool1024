<?php
namespace App\Core\Middlewares;

use Closure;

class ServiceTokenMiddleware
{
    public function handle($request, Closure $next)
    {
        $series = $request->header('app-series');
        $token = $request->header('app-token');
        $platform = $request->header('ng-params-three');
        return $next($request);
    }
}