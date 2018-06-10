<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CreateCmd extends Command
{
    /**
     * 控制台命令 signature 的名称。
     *
     * @var string
     */
    protected $signature = 'make:command {class}';

    /**
     * 控制台命令说明。
     *
     * @var string
     */
    protected $description = '说明下这个命令做什么';

    /**
     * 执行控制台命令。
     *
     * @return mixed
     */
    public function handle()
    {
        // 获取命令参数class
        var_dump($this->argument('class'));
    }
}