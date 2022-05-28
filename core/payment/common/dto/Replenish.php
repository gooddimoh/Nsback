<?php

namespace shop\payment\dto;

class Replenish
{
    public $sum;
    public $paymentId;

    public function __construct($sum, $paymentId)
    {
        $this->sum = $sum;
        $this->paymentId = $paymentId;

    }
}