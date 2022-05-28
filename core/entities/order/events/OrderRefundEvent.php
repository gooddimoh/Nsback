<?php

namespace core\entities\order\events;

use core\entities\order\Refund;

class OrderRefundEvent
{
    public $refund;

    public function __construct(Refund $refund)
    {
        $this->refund = $refund;
    }

}