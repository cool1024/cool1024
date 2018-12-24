<?php

// 监听服务器运行地址
$SERVER_HOST = "https://www.cool1024.com";

// 监听服务器运行端口号
$SERVER_HOST_PORT = 8888;

// 项目部署匹配地址
$SERVER_URL = 'https://$head.cool1024.com/$file';

function sendResponse($response, $message)
{
    $response->header("Content-Type", "text/plain");
    $response->end($message);
}

$http = new swoole_http_server($SERVER_HOST, $SERVER_HOST_PORT, SWOOLE_PROCESS, SWOOLE_SOCK_TCP | SWOOLE_SSL);
$http->set(array(
    'ssl_cert_file' => '/var/www/letsencrypt.sh/certs/fullchain.pem',
    'ssl_key_file' => '/var/www/letsencrypt.sh/certs/privkey.pem',
));

$http->on("start", function ($server) {
    echo "服务器已经开启\n";
});

$http->on("request", function ($request, $response) use ($SERVER_URL) {

    if (!isset($request->server['query_string'])) {
        return sendResponse($response, '缺少请求参数');
    }


    $query_string = $request->server['query_string'];

    $url = '';

    if (empty($query_string)) {
        return sendResponse($response, '缺少请求参数');
    }

    try {
        parse_str($query_string, $parr);
        if (!isset($parr['url'])) {
            return sendResponse($response, '参数错误');
        }
        $url = $parr['url'];
    } catch (Exception $e) {
        return sendResponse($response, '参数解析错误');
    }


    $url = $url . "?password=" . $request->header['x-gitee-token'];

    $path = '';

    try {
        $path = file_get_contents($url);
    } catch (Exception $e) {
        return sendResponse($response, 'REQUEST ERROR : ' . $url);
    }

    var_dump($path);

    if ($path === ' ERROR ') {
        return sendResponse($response, ' ERROR PASSWORD');
    }

    $result = exec("git -C {$path} pull 2>&1");

    var_dump($result);

    return sendResponse($response, $result);
});

$http->start();
