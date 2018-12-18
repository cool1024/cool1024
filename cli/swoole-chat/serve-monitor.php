<?php

/**
 * 系统状态监视脚本
 */

class Vmstat
{
    private $logs;

    public function __construct()
    {
        $this->logs = [];
    }

    public function newLog()
    {
        $datas = exec('vmstat');
        preg_match_all("/\d*/", $datas, $arr);
        $datas = [];
        foreach ($arr[0] as $value) {
            if ($value !== '') {
                $datas[] = $value;
            }
        }
        $datas = [
            'r' => $datas[0], // 运行队列数
            'b' => $datas[1],// 阻塞进程数
            'swpd' => $datas[2], // 虚拟内存使用数
            'free' => $datas[3], // 空闲物理内存
            'buff' => $datas[4], // 系统使用物理内存
            'cache' => $datas[5], // 文件缓存
            'si' => $datas[6], // 每秒读入虚拟内存数据量
            'so' => $datas[7], // 
            'bi' => $datas[8],
            'bo' => $datas[9],
            'in' => $datas[10],
            'cs' => $datas[11],
            'us' => $datas[12],
            'sy' => $datas[13],
            'id' => $datas[14],
            'wa' => $datas[15],
        ];
        $this->logs = $datas;
        return $datas;
    }

    public function avgLogs()
    {
        $totals = array_reduce($this->logs, function ($result, $log) {
            foreach ($log as $eky => $value) {
                $result[$key] += $value;
            }
        });
        foreach ($totals as $key => $value) {
            $totals[$key] = $value / count($this->logs);
        }
        return $totals;
    }

    public function getLogs()
    {
        return $this->logs;
    }

    public function cleanLogs()
    {
        $this->logs = [];
    }
}

$server = new swoole_websocket_server("139.129.161.216", 8080);

$server->on('open', function ($server, $req) {
    echo "connection open: {$req->fd}\n";
    $server->push($req->fd, '');
});

$server->on('message', function ($server, $frame) {
});

$server->on('close', function ($server, $fd) {
});

$server->on('request', function (swoole_http_request $request, swoole_http_response $response) use ($server) {

    $vmstat = new Vmstat();
    $log = $vmstat->newLog();
    foreach ($server->connections as $fd) {
        if ($request->fd !== $fd) {
            $server->push($fd, json_encode($log));
        }
    }
    return $response->end('push success');
});

$server->start();