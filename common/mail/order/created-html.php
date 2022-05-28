<?php

use core\entities\order\Order;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $order Order */

?>

<ul>
    <li>Заказ: <?= $order->getId() ?></li>
    <li>После оплаты будет доступен на странице заказа</li>
    <li><a href="<?= $order->getInfoPage() ?>"><?= $order->getInfoPage() ?></a></li>
</ul>


<?php echo $this->render('_order-detail-html', ['order' => $order]) ?>