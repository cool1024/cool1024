<?php
$server = new swoole_websocket_server("www.cool1024.com", 443, SWOOLE_PROCESS, SWOOLE_SOCK_TCP | SWOOLE_SSL);
$server->set(array(
    'ssl_cert_file' => '/var/www/letsencrypt.sh/certs/cool1024.com/fullchain-1519371728.pem',
    'ssl_key_file' => '/var/www/letsencrypt.sh/certs/cool1024.com/privkey-1519371728.pem',
));
// $server = new swoole_websocket_server("192.168.1.197", 9502);

$server->on('open', function ($server, $req) {
    echo "connection open: {$req->fd}\n";
    $server->push($req->fd, json_encode(["type" => "text", "content" => "connection open"], JSON_UNESCAPED_UNICODE));
});

$server->on('message', function ($server, $frame) {
    echo "received message: {$frame->data}\n";
    // 根据收到的消息进行不同的操作---通常我们不用websocket接受客户端消息，客户端发送消息统一用http请求
    foreach ($server->connections as $fd) {
        if ($frame->fd !== $fd) {
            // 发送这条消息给其他人
            $server->push($fd, $frame->data);
        }
    }
});

$server->on('close', function ($server, $fd) {
    echo " connection close : {$fd} \n ";
});

// 发送消息推送
$server->on('request', function (swoole_http_request $request, swoole_http_response $response) {
    global $server;
    // $server->connections 遍历所有websocket连接用户的fd，给所有用户推送
    return $response->end('push success');
    foreach ($server->connections as $fd) {
        if ($request->fd !== $fd) {
            $server->push($fd, $request->get['message']);
        }
    }
});

$server->start();