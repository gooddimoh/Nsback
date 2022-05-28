<?php

namespace core\payment\lava;

use core\entities\order\Order;
use core\entities\payment\Payment;
use core\payment\BackUrl;
use core\payment\common\Receipt;
use core\settings\storage\LavaSettings;
use yii\helpers\Url;

class LavaReceipt implements Receipt
{
    private $client;
    private $settings;

    public function __construct(LavaClient $client, LavaSettings $settings)
    {
        $this->client = $client;
        $this->settings = $settings;
    }

    public function getPaymentUrl(Payment $payment, $description, $backUrl)
    {
        $invoice = (new InvoiceCreate($this->settings->getWalletTo(), $payment->sum, InvoiceCreate::SUBTRACT_CUSTOMER))
            ->setSuccessUrl($backUrl)
            ->setFailUrl($backUrl)
            ->setOrderId($payment->id)
            ->setComment($description)
            ->setHookUrl(Url::to(['/payment/webhook/lava/callback'], 'https'));

        $response = $this->client->createInvoice($invoice);

        return $response['url'];
    }
}