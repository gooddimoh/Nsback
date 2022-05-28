<?php

/**
 * @var $this \yii\web\View
 */

use core\entities\payment\Payment;
use core\helpers\finance\PaymentHelper;

$this->title = "Платежи";

$paymentUnpaid = PaymentHelper::statusLabel(Payment::STATUS_UNPAID);
$paymentPaid = PaymentHelper::statusLabel(Payment::STATUS_PAID);
$paymentCanceled = PaymentHelper::statusLabel(Payment::STATUS_CANCELED);
?>

<div class="col-md-2">
    <?= $this->render("_menu") ?>
</div>
<div class="col-md-10">
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Платежи</h3>
        </div>
        <div class="box-body">
            <div class="col-md-9">
                <h4 class="text-info">Статусы платежей</h4>
                <ul>
                    <li>
                        <?= $paymentUnpaid ?> - заказ успешно создан, но ещё не оплачен. Либо ещё не обработан платежной
                        системой.
                    </li>
                    <li>
                        <?= $paymentPaid ?> - успешно оплачено.
                    </li>
                    <li>
                        <?= $paymentCanceled ?> - может быть выставлен вручную администратором. Если данный статус
                        выставлен, но пользователь произвёл оплату - платеж не будет зачислен всё-равно.
                    </li>
                </ul>

                <h4 class="text-info">Пользователь оплатил, но статус всё-равно <?= $paymentUnpaid ?>. Как на это
                    повлиять?</h4>
                <div>
                    <p>
                        На данный момент Вы <u>никак</u> не можете на это повлиять.
                    </p>
                    <p>
                        Если Вы убедились, что платеж действительно проведен - обратитесь к разработчику. Он
                        самостоятельно переведен платеж в оплаченные, и отправит заказ выполняться.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>