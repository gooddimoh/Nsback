<?php
/** @var $order Order */

use core\entities\order\Order;

?>

Название товара:
<?php echo $order->product->name ?>

Количество:
<?= $order->quantity ?> шт.

Цена:
<?= $order->cost ?> ₽