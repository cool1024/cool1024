<?php

use App\Api\Contracts\FormContract;
use App\Sdk\IdCardReader;
use App\Jobs\ExampleJob;
use Pheanstalk\Pheanstalk;
use App\Events\ExampleEvent;
use App\Http\Store\Models\StoreUser;
use App\Sdk\Alipay;
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
 */

// 响应数据格式化中间件测试--返回字符串
$router->get('format/string', function (FormContract $api) {
    return 'test string datas';
});

// 响应数据格式化中间件测试--重定向
$router->get('format/redirect', function (FormContract $api) {
    return redirect('tooltest/format/string');
});

// 响应数据格式化中间件测试--返回数组
$router->get('format/array', function (FormContract $api) {
    return $api->datas(['article_title' => 'test title', 'article_type' => 20]);
});

// 响应数据格式化中间件测试--返回试图
$router->get('format/view', function (FormContract $api) {
    return view('simple', ['name' => 'lumen']);
});

// 使用FormService校验表单数据
$router->post('form', function (FormContract $form) {
    $rules = [
        ['a_b', 'integer|max:100'],
        ['b_c_d', 'required|string|max:45'],
        // 没有required的参数是可选参数
        ['c', 'max:45'],
    ];

    $formats = [
        // 将会把参数a变为abort_a
        'a_b' => 'abort_a',
        // $key为原来参数名‘b’,$value为参数的值，这个返回值$key.$value为新的参数名称替换掉'b'
        'b_c_d' => function ($key, $value) {
            return $key . $value;
        }
    ];

    // 使用checkForm系列的方法可以自定义参数名称格式化
    // $params = $form->chekFormOrFail($rules, $formats);

    // 使用camelForm系列的方法将会强制要求参数为小驼峰，而方法返回值依旧可以保持之前的下划线
    $params = $form->camelFormOrFail($rules);

    return $params;
});

// 使用身份证识别
$router->post('idcard', function (FormContract $api) {
    $params = $api->checkFormOrFail(['base64']);
    $reader = new IdCardReader('6b0c12cf6b1386344dba1a61c6433db1', '0199ab7f344e4ad083cdae2444e7f261');
    $result = $reader->readBase64($params['base64']);
    return $result === false ? $api->error('接口调用失败') : $api->datas($result);
});

// 添加一个任务到队列
$router->get('queue', function (FormContract $api) {
    dispatch(new ExampleJob);
    return $api->getMessage('推送到任务队列成功');
});

// 测试手动触发一个事件
$router->get('events', function (FormContract $api) {
    event(new ExampleEvent('事件消息'));
    return $api->getMessage('传递事件消息成功');
});

// 测试ORM事件与观察者
$router->get('observer', function (FormContract $api) {
    // 测试创建事件
    $user = StoreUser::create([
        'uid' => 0,
        'avatar' => '',
        'nick' => '',
        'mobile' => '',
    ]);

    // 测试更新事件
    $user->uid = 1;
    $user->save();

    // 测试删除事件
    $user->delete();

    return $api->getMessage('测试观察者成功');
});

// 测试反射
$router->get('routes', function () {
    $source_routes = app()->router->getRoutes();
    $routes = [];

    // 剔除掉没有控制器的方法
    foreach ($source_routes as $key => $value) {
        if (isset($value['action']['uses'])) {
            $routes[] = $value;
        }
    }

    // 对这些控制器进行分析
    foreach ($routes as $key => $value) {
        $route = [
            'method' => $value['method'],
            'uri' => $value['uri'],
            'uses' => $value['action']['uses'],
        ];
        $args = explode('@', $value['action']['uses']);
        $method = new ReflectionMethod(...$args);
        $route['docs'] = $method->getDocComment();
        $route['vars'] = [];
        preg_match_all("/@var.*?\n/", $route['docs'], $route['vars']);
        $vars = array_first($route['vars']);
        $route['vars'] = count($vars) > 0 ? $vars : [];
        foreach ($route['vars'] as $key => $var) {
            $route['vars'][$key] = preg_split('/\s{1,}/', $var);
        }
        $routes[$key] = $route;
    }

    // 格式化为apidocs

    return $routes;
});

// 测试支付宝支付
$router->get('alipay', function () {
    $alipay = new Alipay();
    // $price, $title, $body, $ordersn
    $url = $alipay->initWebOrderData(0.01, '商品支付测试', '测试订单', date('Ymdhis'));
    // dd($url);
    return redirect($url);
});

// 测试支付宝订单查询
$router->get('alipay/search', function () {
    $alipay = new Alipay();
    return $alipay->orderFind('H830203025515852');
});