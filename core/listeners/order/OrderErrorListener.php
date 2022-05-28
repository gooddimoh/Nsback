<?php

namespace core\listeners\order;

use backend\helpers\UrlNavigatorBackend;
use core\entities\order\events\OrderErrorEvent;
use core\entities\order\Order;
use core\lib\errorManager\ErrorExpert;
use core\lib\telegram\TelegramMessage;

class OrderErrorListener
{
    private $telegramMessage;

    public function __construct(TelegramMessage $telegramMessage)
    {
        $this->telegramMessage = $telegramMessage;
    }

    public function handle(OrderErrorEvent $event)
    {
        try {
            $this->tryBalanceNotify($event->order);
        } catch (\Exception $exception) {
            \Yii::$app->errorHandler->logException($exception);
        };
    }

    protected function tryBalanceNotify(Order $order)
    {
        if (ErrorExpert::isLowBalanceError($order->error_data)) {
            $url = \Yii::$app->backendUrlManager->createAbsoluteUrl(UrlNavigatorBackend::viewOrder($order->getId()));

            $message[] = "Закончился баланс в магазине: " . $order->product->productImport->shop->name;
            $message[] = "Заказ: $url";

            $this->telegramMessage->sendMessage(\Yii::$app->params['telegram.ceoChat.id'], implode(PHP_EOL, $message));
        }
    }

}