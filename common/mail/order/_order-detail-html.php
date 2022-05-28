<?php

use core\entities\order\Order;

/**
 * @var $order Order
 */
?>


<ul>
    <li><?= $order->product->name ?></li>
    <li><?= $order->quantity ?> шт.</li>
    <li>Цена: <?= $order->cost ?></li>
</ul>

