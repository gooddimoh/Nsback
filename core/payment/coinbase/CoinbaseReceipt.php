<?php

namespace core\payment\coinbase;

use core\payment\BackUrl;
use Yii;
use core\entities\order\Order;
use core\entities\payment\Payment;
use core\payment\common\Receipt;
use core\settings\storage\CoinbaseSettings;

class CoinbaseReceipt implements Receipt
{
    private $settings;

    public function __construct(CoinbaseSettings $settings)
    {
        $this->settings = $settings;
    }

    public function getPaymentUrl(Payment $payment, $description, $backUrl)
    {
        $coinbase =  new CoinbasePayment($this->settings->getApiKey());

        return $coinbase->create(
            Yii::$app->name,
            $description,
            $payment->sum,
            "RUB",
            ['pay_id' => $payment->id],
            $backUrl,
            $backUrl
        );
    }
}