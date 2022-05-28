<?php

namespace core\entities\order\events;

use core\entities\payment\Payment;

class PaymentCreatedEvent
{
    public Payment $payment;

    public function __construct(Payment $payment)
    {
        $this->payment = $payment;
    }

}