<?php
namespace App\Core\Middlewares;

use Closure;

class FormatMiddleware
{
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        // 如果不是数组那么直接返回响应
        if (gettype($response->getOriginalContent()) !== 'array') {
            return $response;
        }

        // 格式化响应数据下划线转小驼峰
        $datas = $response->getContent();
        $datas = json_decode($datas, true);
        $datas = $this->camelCase($datas);
        $datas = json_encode($datas);
        $response->setContent($datas);
        return $response;
    }

    private function camelCase($arr, $ucfirst = false)
    {
        if (!is_array($arr)) {
            return $arr;
        }
        $temp = [];
        $keys = '';
        foreach ($arr as $key => $value) {
            $temp_key = $this->convertUnderline($key, false);
            $temp_value = $this->camelCase($value);
            $temp[$temp_key] = $temp_value;
        }
        return $temp;
    }

    private function convertUnderline($str, $ucfirst = true)
    {
        $str = ucwords(str_replace('_', ' ', $str));
        $str = str_replace(' ', '', lcfirst($str));
        return $ucfirst ? ucfirst($str) : $str;
    }
}