<?php

/**
 * 注册文件解析器
 * 
 * @file  register.php
 * @autor xiaojian
 * @date  2018.4.3
 */

foreach ($registers as $value) {
    require $value;
}