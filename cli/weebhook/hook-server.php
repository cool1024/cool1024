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
        if (!isset($parr['head']) || !isset($parr['file'])) {
            return sendResponse($response, '参数错误');
        }
        $url = str_replace('$head', $parr['head'], $SERVER_URL);
        $url = str_replace('$file', $parr['file'], $url);
    } catch (Exception $e) {
        return sendResponse($response, '参数解析错误');
    }

    if (!isset($request->post)) {
        return sendResponse($response, 'NO POST PARAMS');
    }

    if (!isset($request->post['hook'])) {
        return sendResponse($response, 'NO HOOK PARAMS');
    }

    $params = json_decode($request->post['hook'], true);

    if (!isset($params) || empty($params)) {
        return sendResponse($response, 'HOOK PARAMS ERROR');
    }

    $url = $url . "?password=" . $params['password'];

    $path = '';

    try {
        $path = file_get_contents($url);
    } catch (Exception $e) {
        return sendResponse($response, 'REQUEST ERROR : ' . $url);
    }

    if ($path === ' ERROR ') {
        return sendResponse($response, ' ERROR PASSWORD');
    }

    $result = exec("git -C {$path} pull 2>&1");

    return sendResponse($response, $result);
});

$http->start();