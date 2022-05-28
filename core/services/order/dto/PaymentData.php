<?php

namespace core\services\order\dto;

use core\entities\order\Order;
use core\entities\payment\Payment;

/**
 * Class PaymentData
 * @package core\services\order\dto
 * @property string $paymentLink
 * @property Order $order
 * @property Payment $payment
 */
class PaymentData
{
    public $paymentLink;
    public $order;
    public $payment;

    public function __construct($paymentLink, $order, $payment)
    {
        $this->paymentLink = $paymentLink;
        $this->order = $order;
        $this->payment = $payment;
    }

}