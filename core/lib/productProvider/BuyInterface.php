<?php

namespace core\lib\productProvider;

use core\entities\order\Order;

interface BuyInterface
{

    /**
     * @param Order $order
     * @return int|string Order ID
     */
    public function buy(Order $order);

    /**
     * @param Order $order
     * @return mixed Product in string(TXT-File)
     */
    public function download(Order $order);

}