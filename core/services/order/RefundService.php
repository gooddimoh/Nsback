<?php

namespace core\services\order;

use backend\forms\order\RefundForm;
use core\entities\order\Refund;
use core\repositories\order\OrderRefundRepository;
use core\repositories\order\OrderRepository;
use core\services\TransactionManager;

class RefundService
{
    private $orders;
    private $transactionManager;
    private $refunds;

    public function __construct(OrderRepository $orders, TransactionManager $transactionManager, OrderRefundRepository $cancels)
    {
        $this->orders = $orders;
        $this->transactionManager = $transactionManager;
        $this->refunds = $cancels;
    }

    public function refund(RefundForm $form, $id)
    {
        $order = $this->orders->get($id);

        $refund = Refund::make($order, $form->comment, $form->quantity, $form->bill, $form->refundToBalance);
        $order->sendToRefund();

        $this->transactionManager->execute(function () use ($order, $refund) {
            $this->orders->save($order);
            $this->refunds->save($refund);
        });

        return $refund;
    }


}