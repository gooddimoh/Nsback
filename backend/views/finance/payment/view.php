<?php

use backend\helpers\UrlNavigatorBackend;
use core\entities\payment\PaymentDeposit;
use core\entities\payment\PaymentOrder;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\DetailView;
use core\entities\payment\Payment;
use core\helpers\finance\PaymentHelper;

/**
 * @var $this View
 * @var $model Payment
 */

$this->title = "Платеж #{$model->id}";
$this->params['breadcrumbs'][] = ['label' => 'Платежи', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box box-default">
    <div class="box-body">
        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                'id',
                'sum',
                [
                    'attribute' => 'method',
                    'value' => function (Payment $model) {
                        return PaymentHelper::methodName($model->method);
                    },
                    'filter' => PaymentHelper::methodList(),
                ],
                [
                    'attribute' => 'status',
                    'format' => 'html',
                    'value' => function (Payment $model) {
                        return PaymentHelper::statusLabel($model->status);
                    },
                    'filter' => PaymentHelper::statusList(),
                ],
                'created_at:date',
                'paid_at:date',
            ],
        ]) ?>
    </div>
</div>

<?php if ($model->isTypeDeposit()): ?>
    <div class="box box-default">
        <div class="box-body">
            <h2>Депозит</h2>
            <?= DetailView::widget([
                'model' => $model->paymentDeposit,
                'attributes' => [
                    [
                        'attribute' => 'user_id',
                        'format' => 'html',
                        'value' => function (PaymentDeposit $model) {
                            return Html::a($model->user->getEncodedUsername(), UrlNavigatorBackend::viewUser($model->user_id));
                        }
                    ],
                ],
            ]) ?>
        </div>
    </div>
<?php endif; ?>

<?php if ($model->isTypeOrder()): ?>
    <div class="box">
        <div class="box-body">
            <h2>Заказ</h2>
            <?= DetailView::widget([
                'model' => $model->paymentOrder,
                'attributes' => [
                    [
                        'attribute' => 'order_id',
                        'format' => 'html',
                        'value' => function (PaymentOrder $model) {
                            return Html::a($model->order_id, UrlNavigatorBackend::viewOrder($model->order_id));
                        },
                        'label' => 'ID',
                    ],
                ],
            ]) ?>
        </div>
    </div>
<?php endif; ?>
