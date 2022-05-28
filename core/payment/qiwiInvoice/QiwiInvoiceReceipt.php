<?php

namespace core\payment\qiwiInvoice;

use core\payment\BackUrl;
use core\settings\storage\QiwiInvoiceSettings;
use Yii;
use core\entities\order\Order;
use core\entities\payment\Payment;
use core\payment\common\Receipt;
use yii\helpers\Url;

class QiwiInvoiceReceipt implements Receipt
{
    protected $settings;

    public function __construct(QiwiInvoiceSettings $settings)
    {
        $this->settings = $settings;
    }

    public function getPaymentUrl(Payment $payment, $description, $backUrl)
    {
        $qiwiP2P = new QiwiP2P($this->settings->getPublicKey(), $this->settings->getSecretKey());

        return $qiwiP2P->createPaymentUrl(
            $payment->sum,
            $payment->id,
            $description,
            $backUrl,
            $this->settings->getPaySource()
        );
    }

}