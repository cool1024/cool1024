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
            if ($fe->getStatusCode() === 201) {
                return response()->json(json_decode($e->getMessage(), true));
            }
            if ($fe->getStatusCode() === 401) {
                return response()->json(['result' => false, 'message' => $fe->getMessage()]);
            }
            if ($fe->getStatusCode() === 404) {
                return response()->json(['result' => false, 'message' => '请求的接口不存在~']);
            }
            if ($fe->getStatusCode() === 405) {
                return response()->json(['result' => false, 'message' => '请求的方式错误~']);
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
