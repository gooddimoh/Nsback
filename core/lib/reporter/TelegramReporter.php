<?php

namespace core\lib\reporter;

use core\lib\telegram\TelegramMessage;

class TelegramReporter implements Reporter
{
    private $service;
    private $to;

    public function __construct(TelegramMessage $service, $to)
    {
        $this->service = $service;
        $this->to = $to;
    }


    public function report($message)
    {
        $this->service->sendMessage($this->to, $message);
    }

}