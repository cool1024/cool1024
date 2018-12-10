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

        // 剔除null参数
        foreach ($params as $key => $value) {
            if ($value === null) {
                $request->offsetUnset($key);
            }
        }

        // 如果是post,put请求那么校验是否需要解开数据包
        if (in_array($request->method(), ['POST', 'PUT']) && $request->has('PACKAGE_PARAMAS')) {
            $params = base64_decode($request->input('PACKAGE_PARAMAS'), true);
            if ($params === false) {
                abort(200, '数据包解析失败，请检查数据包格式-PACKAGE_PARAMAS');
            } else {
                $params = json_decode($params, true);
                if (!is_array($params)) {
                    abort(200, '数据包内容错误不是标准的JSON字符串-PACKAGE_PARAMAS');
                } else {
                    $request->offsetUnset('PACKAGE_PARAMAS');
                    $request->replace($params);
                }
            }
        }

        return $next($request);
    }
}