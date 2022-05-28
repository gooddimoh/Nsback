<?php

namespace core\payment\balance;

use core\entities\order\Order;
use core\entities\payment\Payment;
use core\payment\common\Receipt;
use yii\helpers\Url;

class BalanceReceipt implements Receipt
{

    public function getPaymentUrl(Payment $payment, $description, $backUrl)
    {
        $urlManager = \Yii::$app->frontendUrlManager;

        if (!$payment->isTypeOrder()) {
            return $urlManager->createUrl(['/customer/payment/invalid-type', 'pid' => $payment->id]);
        }

        return \Yii::$app->frontendUrlManager->createUrl([
            '/customer/payment/confirm',
            'payment' => $payment->id,
            'code' => $payment->paymentOrder->order->code,
            'email' => $payment->paymentOrder->order->email,
        ]);
    }

}