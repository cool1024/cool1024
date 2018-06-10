<?php

namespace App\Core\Commands;

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
    protected $description = '创建一个新的命令';

    /**
     * 执行控制台命令。
     *
     * @return mixed
     */
    public function handle()
    {
        $className = $this->argument('class');
        $templatePath = realpath(__DIR__ . '/../Templates') . "/cmd.tpl.php";
        $commandPath = realpath(__DIR__ . '/../../Console/Commands') . "/{$className}.php";
        $tplStr = file_get_contents($templatePath);
        file_put_contents($commandPath, str_replace('CreateCmd', $className, $tplStr));
    }
}