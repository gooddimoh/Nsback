<?php

namespace core\payment\test;

use core\entities\order\Order;
use core\entities\payment\Payment;
use core\payment\BackUrl;
use core\payment\common\Receipt;
use yii\helpers\Url;

class TestReceipt implements Receipt
{
    public function getPaymentUrl(Payment $payment, $description, $backUrl)
    {
        return Url::to(['/payment/test/maze-bank/payment',
            'id' => $payment->id,
            'backUrl' => $backUrl
        ], 'http');
    }
}