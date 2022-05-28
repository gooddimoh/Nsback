<?php

namespace core\payment\common;

use core\entities\order\Order;
use core\entities\payment\Payment;

interface Receipt
{
    public function getPaymentUrl(Payment $payment, $description, $backUrl);

}