<?php

namespace core\payment\webmoney;


class WebMoneyGateway
{
    public const MERCHANT_LINK = 'https://merchant.webmoney.ru/lmi/payment_utf.asp';

    public $payeePurse;
    public $paymentAmount;
    public $paymentDesc;
    public $successUrl;

    public function __construct($payeePurse, $paymentAmount, $paymentDesc, $successUrl = null)
    {
        $this->payeePurse = $payeePurse;
        $this->paymentAmount = $paymentAmount;
        $this->paymentDesc = $paymentDesc;
        $this->successUrl = $successUrl;
    }



}