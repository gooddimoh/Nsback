<?php

namespace core\services\auth\verify;

use core\lib\telegram\TelegramMessage;

class TelegramSender implements VerifySenderInterface
{
    private TelegramMessage $telegramMessage;

    public function __construct(TelegramMessage $telegramMessage)
    {
        $this->telegramMessage = $telegramMessage;
    }

    public function send($addressee, $verifyCode)
    {
        $this->telegramMessage->sendMessage($addressee, "Код для авторизации: \n\n\n$verifyCode");
    }

}