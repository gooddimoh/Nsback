<?php

/**
 * @var $this \yii\web\View
 */

use core\entities\order\Order;
use core\helpers\order\OrderHelper;
use yii\helpers\Html;

$this->title = "Заказы";

$statusUnpaid = OrderHelper::statusName(Order::STATUS_UNPAID);
$statusPending = OrderHelper::statusName(Order::STATUS_PENDING);
$statusCompleted = OrderHelper::statusName(Order::STATUS_COMPLETED);
$statusError = OrderHelper::statusName(Order::STATUS_ERROR);
$statusCanceled = OrderHelper::statusName(Order::STATUS_CANCELED);
$statusCanceledByUser = OrderHelper::statusName(Order::STATUS_CANCELED_BY_USER);
$statusRefund = OrderHelper::statusName(Order::STATUS_REFUND);
$statusSuspended = OrderHelper::statusName(Order::STATUS_SUSPENDED);
$statusProcessing = OrderHelper::statusName(Order::STATUS_PROCESSING);
?>

<div class="col-md-2">
    <?= $this->render("_menu") ?>
</div>
<div class="col-md-10">
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Заказы</h3>
        </div>
        <div class="box-body">
            <h4 class="text-info">Доступные статусы:</h4>
            <ul>
                <li><b><?= $statusUnpaid ?></b> - заказ не оплачен.
                </li>
                <li><b><?= $statusPending ?></b> - заказ оплачен, помещен в очередь на выкуп у Провайдера

                <li><b><?= $statusProcessing ?></b> - происходит выкуп позиции у Провайдера.
                </li>
                <li><b><?= $statusCompleted ?></b> - заказ выкуплен, доступен пользователю к загрузке
                </li>
                <li><b><?= $statusError ?></b> - произошла ошибка при выкупе заказа у Провайдера. Возможные причины: нет в наличии,
                    закончился баланс на аккаунте для покупки, недоступен сайт поставщика.
                </li>
                <li>
                    <b><?= $statusCanceled ?></b> - справочный статус. Заказы с таким статусом не будут пытаться выкупиться.
                    Для пометки отмененных заказов с возвратом средств, используйте статус <?= $statusRefund ?>.
                </li>
                <li><b><?= $statusCanceledByUser ?></b> - отменен пользователем. Пользователь может отменить только
                    заказ в статусе <?= $statusError ?>.
                </li>
                <li>
                    <b><?= $statusRefund ?></b> - заказ отменен полностью/частично, средства пользователю возвращены на баланс.
                </li>
                <li>
                    <b><?= $statusSuspended ?></b> - приостановлен. Не будет пытаться выкупиться.  Приостановка может быть вызвана:<br>
                    <ol>
                        <li><b>Системой.</b> С заказом произошла системная ошибка. Причина указана в "Описании ошибки".</li>
                        <li><b>Менеджером.</b> Например, чтобы убрать оплаченный заказ с очереди на выкуп пока ожидает информацию от покупателя.</li>
                    </ol>
                </li>
            </ul>
        </div>
    </div>
</div>