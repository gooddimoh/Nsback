<?php

namespace core\payment\webmoney;


class WebMoneyGatewayReplenish extends WebMoneyGateway
{
    public $userId;

    public function __construct($payeePurse, $paymentAmount, $paymentDesc, $userId)
    {
        parent::__construct($payeePurse, $paymentAmount, $paymentDesc);
        $this->userId = $userId;
    }
}