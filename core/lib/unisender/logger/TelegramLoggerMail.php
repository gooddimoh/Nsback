<?php

namespace core\lib\unisender\logger;

use core\entities\mail\Mail;
use core\helpers\JsonHelper;
use core\lib\telegram\TelegramMessage;
use yii\helpers\Json;

class TelegramLoggerMail extends LoggerMail
{
    private $telegram;

    public function __construct(TelegramMessage $telegram)
    {
        $this->telegram = $telegram;
    }

    public function fail($error)
    {
        $this->telegram->sendMessage(\Yii::$app->params['telegram.developerChat.id'], "UniSender Error: $error");
    }

}