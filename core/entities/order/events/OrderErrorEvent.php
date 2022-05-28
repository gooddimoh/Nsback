<?php

namespace core\entities\order\events;

use core\entities\order\Order;

class OrderErrorEvent
{
    public $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }


}