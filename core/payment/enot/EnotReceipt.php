<?php

namespace core\payment\enot;

use core\entities\order\Order;
use core\entities\payment\Payment;
use core\payment\BackUrl;
use core\payment\common\Receipt;
use core\settings\storage\EnotSettings;
use yii\helpers\Url;

class EnotReceipt implements Receipt
{
    private $settings;

    public function __construct(EnotSettings $settings)
    {
        $this->settings = $settings;
    }

    public function getPaymentUrl(Payment $payment, $description, $backUrl)
    {
        $enotPaymentCreator = new EnotPaymentCreator(
            $this->settings->getMerchantId(),
            $this->settings->getFirstSecret(),
            $payment->sum,
            $payment->id,
            [
                'success_url' => $backUrl,
                'fail_url' => $backUrl,
            ]
        );

        return $enotPaymentCreator->getPaymentLink();
    }
}