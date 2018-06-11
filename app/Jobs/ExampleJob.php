<?php

namespace App\Jobs;

use Carbon\Carbon;

class ExampleJob extends Job
{

    private $log_path;

    /**
     * 创建一个任务实例
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * 执行这个任务
     *
     * @return void
     */
    public function handle()
    {
        sleep(10);
        $path = realpath(__DIR__ . '/../../storage/logs') . '/jobs.log';
        $snapshot = shell_exec('vm_stat');
        file_put_contents($path, 'Save snapshot at ' . Carbon::now() . "\n", FILE_APPEND);
        file_put_contents($path, $snapshot . "\n", FILE_APPEND);
    }
}
