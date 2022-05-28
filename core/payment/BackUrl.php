<?php

namespace core\payment;

use core\entities\order\Order;
use yii\helpers\Url;

class BackUrl
{

    public static function createForDeposit()
    {
        return Url::to(['/deposit/index'], 'https');
    }

    public static function createForOrder(Order $order)
    {
        return Url::to(['/order/back', 'code' => $order->code, 'email' => $order->email], 'https');
    }

}