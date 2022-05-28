<?php

use core\entities\payment\Payment;
use core\forms\deposit\DepositForm;
use core\helpers\finance\PaymentHelper;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $model DepositForm */
/* @var $history \yii\data\ActiveDataProvider */

$this->title = "Пополнить баланс";
?>

<div>
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'method')->dropDownList($model::getMethodList()) ?>

    <?= $form->field($model, 'sum') ?>

    <div class="form-group">
        <?= Html::submitButton('Пополнить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>

<div>
    <?= GridView::widget([
        'dataProvider' => $history,
        'columns' => [
            'id',
            [
                'attribute' => 'method',
                'value' => function (Payment $model) {
                    return PaymentHelper::methodName($model->method);
                },
            ],
            [
                'attribute' => 'status',
                'format' => 'html',
                'value' => function (Payment $model) {
                    return PaymentHelper::statusLabel($model->status);
                },
            ],
            'created_at:date',
            'paid_at:date',
        ]
    ]) ?>
</div>