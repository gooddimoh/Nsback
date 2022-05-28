<?php

namespace core\services\order;

use core\lib\reporter\Reporter;
use core\repositories\order\OrderRepository;
use yii\helpers\StringHelper;

class UnsavedPurchaseService
{
    private $orders;
    private $reporter;

    public function __construct(OrderRepository $orders, Reporter $reporter)
    {
        $this->orders = $orders;
        $this->reporter = $reporter;
    }

    public function suspend($id, $reason, $invoiceId)
    {
        $message = "Invoice: $invoiceId.\n\nReason:"  . StringHelper::truncate($reason, 500);

        try {
            $order = $this->orders->get($id);
            $order->suspendByError($message);
            $this->orders->save($order);
        } finally {
            $this->reporter->report("Товар для заказа №$id выкуплен, но не удалось сохранить результат. Детали: $message");
        }
    }

}