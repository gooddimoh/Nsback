<?php

namespace core\listeners\order;

use backend\helpers\UrlNavigatorBackend;
use core\entities\order\events\OrderRefundEvent;
use core\lib\emoji\Emoji;
use core\lib\telegram\TelegramMessage;
use core\services\user\BalanceService;
use yii\helpers\Html;

class OrderRefundListener
{
    private $balanceService;
    private $telegramMessage;

    public function __construct(BalanceService $balanceService, TelegramMessage $telegramMessage)
    {
        $this->balanceService = $balanceService;
        $this->telegramMessage = $telegramMessage;
    }

    public function handle(OrderRefundEvent $event)
    {
        $this->moneyBack($event);
    }

    protected function moneyBack(OrderRefundEvent $event)
    {
        $cancel = $event->refund;
        $order = $cancel->order;

        if ($cancel->isRefundToBalance()) {
            $this->balanceService->addBalance($order->user_id, $cancel->sum, "Возврат за заказ №{$cancel->order_id}");
        } else {
            $orderUrl = \Yii::$app->backendUrlManager->createAbsoluteUrl(UrlNavigatorBackend::viewOrder($order->getId()));

            $message[] = Emoji::SHOPPING_BAGS . Html::a("Заказ №{$order->getId()}", $orderUrl);
            $message[] = Emoji::SPEECH_BALLOON . "Комментарий: $cancel->comment";
            $message[] = Emoji::C_CREDIT_CARD . "Счёт: $cancel->bill";
            $message[] = Emoji::C_MONEY_WITH_WINGS . "Сумма: <b>$cancel->sum</b> RUB";

            $this->telegramMessage->sendMessage(\Yii::$app->params['telegram.refundChat.id'], implode(PHP_EOL, $message));
        }
    }


}