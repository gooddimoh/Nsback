<?php

namespace core\payment\freekassa;

use core\entities\order\Order;
use core\entities\payment\Payment;
use core\payment\common\Receipt;
use core\settings\storage\FreekassaSettings;

class FreekassaReceipt implements Receipt
{
    private $settings;

    public function __construct(FreekassaSettings $settings)
    {
        $this->settings = $settings;
    }

    public function getPaymentUrl(Payment $payment, $description, $backUrl)
    {
        $freekassaPaymentCreator = new FreekassaPaymentCreator(
            $this->settings->getShopId(),
            $this->settings->getFirstKey(),
            $payment->sum,
            $payment->id,
            'RUB'
        );

        return $freekassaPaymentCreator->getPaymentLink();
    }

}