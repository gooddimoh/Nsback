<?php

namespace core\payment\webmoney;

use core\payment\BackUrl;
use core\settings\storage\WebMoneySettings;
use Yii;
use core\entities\order\Order;
use core\entities\payment\Payment;
use core\payment\common\Receipt;

class WebMoneyReceipt implements Receipt
{
    private $settings;

    public function __construct(WebMoneySettings $settings)
    {
        $this->settings = $settings;
    }

    public function getPaymentUrl(Payment $payment, $description, $backUrl)
    {
        return Yii::$app->urlManager->createAbsoluteUrl([
            '/payment/gateway/web-money',
            'sum' => $payment->sum,
            'paymentId' => $payment->id,
            'wallet' => $this->settings->getRWallet(),
            'successUrl' => $backUrl,
        ]);
    }

}