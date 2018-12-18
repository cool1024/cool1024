<?php

//-------------------------------------------------------
// Example Command
//
// php description.php 要去掉注释的文件夹路径
//
// 注意，运行这个脚本你先要cd到description.php文件所在的文件夹中
// 去掉注释的代码文件夹就在escription.php同一个文件夹中
//-------------------------------------------------------

/**
 * php 批量去掉文件注释脚本
 * 
 * @author xiaojian
 * @date 2018年03月16日
 * @file description.php
 */

function list_files($path, $ext)
{
    $tree = array();
    $temp = glob($path . "/*" . $ext);
    if ($temp) $tree = array_merge($tree, $temp);
    foreach (glob($path . "/*", GLOB_ONLYDIR) as $dir) {
        $temp = list_files($dir, $ext);
        if ($temp) $tree = array_merge($tree, $temp);
    }

    return $tree;
}

function copydir($source, $dest)
{
    if (!file_exists($dest)) mkdir($dest);
    $handle = opendir($source);
    while (($item = readdir($handle)) !== false) {
        if ($item == '.' || $item == '..') continue;
        $_source = $source . '/' . $item;
        $_dest = $dest . '/' . $item;
        if (is_file($_source)) copy($_source, $_dest);
        if (is_dir($_source)) copydir($_source, $_dest);
        echo 'copy dir' . $source . PHP_EOL;
    }
    closedir($handle);
}

function main($argc, $argv)
{
    if ($argc <= 1) {
        echo 'no target dir name' . PHP_EOL;
        exit(0);
    }

    $copy_path = __DIR__ . '/' . date('ymdhis');

    echo 'cop file to' . $copy_path . PHP_EOL;

    copydir($argv[1], $copy_path);

    echo 'running...' . $copy_path . PHP_EOL;

    $files = list_files($copy_path, 'php');

    foreach ($files as $file) {
        $content = file_get_contents($file);
        $content = preg_replace('/(\/\/.*)|(\/\*[\s\S]*?\*\/)/', '', $content);
        file_put_contents($file, $content);
        echo 'success...' . $file . PHP_EOL;
    }
}

main($argc, $argv);

?>