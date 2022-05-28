<?php

namespace core\payment\payeer;

use core\entities\order\Order;
use core\entities\payment\Payment;
use core\payment\common\Receipt;
use yii\helpers\Url;

class PayeerReceipt implements Receipt
{

    public function getPaymentUrl(Payment $payment, $description, $backUrl)
    {
        return Url::to([
            '/payment/gateway/payeer',
            'paymentId' => $payment->id,
            'sum' => $payment->sum,
            'backUrl' => $backUrl,
        ]);
    }
}