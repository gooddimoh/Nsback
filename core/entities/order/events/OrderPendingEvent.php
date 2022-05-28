<?php

namespace core\entities\order\events;

use core\entities\order\Order;

class OrderPendingEvent
{
    public $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }


}