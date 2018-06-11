<?php

namespace App\Events;

class ExampleEvent extends Event
{

    private $message;

    /**
     * 创建一个事件实例
     *
     * @return void
     */
    public function __construct($message)
    {
        $this->message = $message;
    }

    /**
     * 获取事件消息
     * 
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }
}
