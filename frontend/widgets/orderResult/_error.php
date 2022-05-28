<?php
/**
 * @var array $textList
 * @var CustomerErrorMessage $errorMessage
 * @var $order Order
 */

use core\entities\order\Order;
use core\lib\errorManager\CustomerErrorMessage;
use yii\helpers\Html;

?>

<div>
    <span class="title--main font-32">
        <?= $textList['title'] ?><br>
    </span>
    <div class="font-16 pt-5">
        <div class="well font-16 text-left">
            <?= nl2br($errorMessage->getUserMessage()) ?>
            <br><br>
            <b>Сообщение для поддержки:</b> <?= $errorMessage->getSupportMessage() ?> (Заказ №<?php echo $order->id ?>)
        </div>
    </div>
    <div class="pb-10 text-center">
        <?= Html::a("Отменить заказ", ['/order/cancel', 'email' => $order->email, 'code' => $order->code], [
            'class' => 'button-doted',
            'data' => ['confirm' => "Вы можете отменить заказ, если не хотите ждать решения проблемы. Отменить заказ?"],
        ]) ?>
    </div>
</div>
