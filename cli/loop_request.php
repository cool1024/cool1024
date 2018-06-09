<?php
set_time_limit(0);

/**
 * 请求的地址列表
 */
$requestUrls = [
    'http://192.168.1.166:8080',
];

/**
 * 请求间隔时间
 */
$timeSleep = 2;

/**
 * 循环请求
 */
while (true) {
    foreach ($requestUrls as $url) {
        file_get_contents($url);
    }
    sleep($timeSleep);
}