<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;

class SaveSnapshot extends Command
{
    /**
     * 控制台命令 signature 的名称。
     *
     * @var string
     */
    protected $signature = 'snapshot:save';

    /**
     * 控制台命令说明。
     *
     * @var string
     */
    protected $description = '保存系统快照';

    /**
     * 执行控制台命令。
     *
     * @return mixed
     */
    public function handle()
    {
        $path = realpath(__DIR__ . '/../../../storage/logs') . '/jobs.log';
        $snapshot = shell_exec('vm_stat');
        file_put_contents($path, 'Save snapshot at ' . Carbon::now() . "\n", FILE_APPEND);
        file_put_contents($path, $snapshot . "\n", FILE_APPEND);
    }
}