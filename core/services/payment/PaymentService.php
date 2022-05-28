<?php

namespace core\services\payment;

use core\entities\order\Order;
use core\entities\payment\Payment;
use core\payment\common\ReceiptFactory;
use core\repositories\order\PaymentRepository;

class PaymentService
{
    private $payments;

    public function __construct(PaymentRepository $payments)
    {
        $this->payments = $payments;
    }

    public function createPaymentUrlForOrder(Order $order, Payment $payment)
    {
        return ReceiptFactory::createOrder($order, $payment);
    }

    public function createPaymentUrlForDeposit(Payment $payment)
    {
        return ReceiptFactory::createDeposit($payment);
    }

    public function paidByReplenish($paymentId, $sum, $validateSum = true)
    {
        $payment = $this->payments->get($paymentId);

        if ($validateSum && !$payment->isSumEquivalent($sum)) {
            throw new \InvalidArgumentException("Sum {$sum} not equivalent to " . $payment->getSum());
        }

        $this->paid($payment);
    }

    public function paidManually($paymentId)
    {
        $payment = $this->payments->get($paymentId);
        $payment->markAsPaidManually();

        $this->paid($payment);
    }

    public function cancel($id)
    {
        $payment = $this->payments->get($id);
        $payment->cancel();
        $this->payments->save($payment);
    }

    protected function paid(Payment $payment)
    {
        $payment->paid();
        $this->payments->save($payment);
    }


}