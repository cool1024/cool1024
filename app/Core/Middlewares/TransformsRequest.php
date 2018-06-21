<?php
namespace App\Core\Middlewares;

use Closure;

use Symfony\Component\HttpFoundation\ParameterBag;

class TransformsRequest
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $params = $request->all();
        foreach ($params as $key => $value) {
            if ($value === null) {
                $request->offsetUnset($key);
            }
        }
        return $next($request);
    }
}