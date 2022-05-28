<?php

use core\entities\order\Order;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $order Order */

?>

<div>
    <p>Заказ #<?= $order->getId() ?> оплачен!</p>
    <p>Ваш товар вскоре будет доступен к загрузке!</p>

    <p>Прямая ссылка на товар: <?= $order->getInfoPage() ?></p>
</div>

<?php echo $this->render('_order-detail-html', ['order' => $order]) ?>
