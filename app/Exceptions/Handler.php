<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Laravel\Lumen\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Debug\Exception\FlattenException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        AuthorizationException::class,
        HttpException::class,
        ModelNotFoundException::class,
        ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $e
     * @return void
     */
    public function report(Exception $e)
    {
        parent::report($e);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $e
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $e)
    {
        // Http响应异常处理
        if ($e instanceof HttpException) {
            $fe = FlattenException::create($e);
            switch ($fe->getStatusCode()) {

                // 数据处理中途出现异常，但是不是请求本身，而是来自系统内部的错误，这里依然返回200
                case 200:
                    return response()->json([
                        'result' => false,
                        'message' => $e->getMessage()
                    ]);
                    
                // 权限令牌错误，需要登入
                case 401:
                    return response()->json([
                        'result' => false,
                        'message' => $fe->getMessage()
                    ], 401);

                // 拒绝访问，令牌权限不够
                case 403:
                    return response()->json([
                        'result' => false,
                        'message' => $fe->getMessage()
                    ], 403);

                // 请求的资源不存在
                case 404:
                    return response()->json([
                        'result' => false,
                        'message' => '请求的接口不存在~'
                    ]);

                // 请求方式错误    
                case 405:
                    return response()->json([
                        'result' => false,
                        'message' => '请求的方式错误~'
                    ]);  

                // 请求参数错误                    
                case 422:
                    return response()->json(json_decode($e->getMessage(), true));
            }
        } 
        // 模型查询异常处理
        else if ($e instanceof ModelNotFoundException) {
            return response()->json(['result' => false, 'message' => '请求的数据不存在~']);
        }
        // 表单校验异常处理
        else if ($e instanceof ValidationException) {
            return response()->json(
                [
                    'result' => false,
                    'message' => $e->validator->messages()
                ],
                $e->status
            );
        }
        return parent::render($request, $e);
    }
}
