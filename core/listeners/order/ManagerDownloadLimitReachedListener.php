<?php

namespace core\listeners\order;

use core\entities\order\events\DownloadLimitReachedEvent;
use core\lib\telegram\TelegramMessage;
use core\lib\telegram\template\ManagerDownloadLimitReachedTemplate;
use Yii;

class ManagerDownloadLimitReachedListener
{
    private TelegramMessage $telegramMessage;

    public function __construct(TelegramMessage $telegramMessage)
    {
        $this->telegramMessage = $telegramMessage;
    }

    public function handle(DownloadLimitReachedEvent $event)
    {
        $template = Yii::$container->get(ManagerDownloadLimitReachedTemplate::class);
        $template->createMessage($event->userId, $event->quantity);

        Yii::info("Event reached");

        $this->telegramMessage->sendMessageByTemplate($template, Yii::$app->params['telegram.ceoChat.id']);
    }


}