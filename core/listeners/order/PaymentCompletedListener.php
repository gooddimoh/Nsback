<?php

namespace core\listeners\order;

use core\lib\unisender\RenderMail;
use core\lib\unisender\UnisenderWrapper;
use core\services\deposit\DepositService;
use Yii;
use core\entities\order\events\PaymentCompletedEvent;
use core\services\order\OrderService;

class PaymentCompletedListener
{
    private OrderService $orderService;
    private UnisenderWrapper $unisenderApi;
    private DepositService $depositService;

    public function __construct(
        OrderService     $orderService,
        UnisenderWrapper $unisenderApi,
        DepositService $depositService
    )
    {
        $this->orderService = $orderService;
        $this->unisenderApi = $unisenderApi;
        $this->depositService = $depositService;
    }

    public function handle(PaymentCompletedEvent $event)
    {
        if ($event->payment->isTypeOrder()) {
            $this->sendOrderToPending($event);
            $this->notifyByUnisender($event);
        }
        if ($event->payment->isTypeDeposit()) {
            $this->depositService->confirm($event->payment->id);
        }
    }

    protected function sendOrderToPending(PaymentCompletedEvent $event)
    {
        try {
            $this->orderService->sendToPending($event->payment->paymentOrder->order_id);
        } catch (\Exception $exception) {
            Yii::error($exception->getMessage(), "webhook");
            Yii::$app->errorHandler->logException($exception);
        }
    }

    protected function notifyByUnisender(PaymentCompletedEvent $event)
    {
        $order = $event->payment->paymentOrder->order;

        $this->unisenderApi->sendEmail(
            $order->email,
            "Заказ #{$order->getId()} оплачен | " . Yii::$app->name,
            RenderMail::render("order/paid-html", ['order' => $order])
        );
    }

}