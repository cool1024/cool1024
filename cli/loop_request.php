<?php

/**
 * 链接定期访问脚本
 */

set_time_limit(0);

/**
 * 请求的地址列表
 */
$requestUrls = [
    'http://139.129.161.216:8080',
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