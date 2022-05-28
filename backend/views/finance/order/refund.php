<?php

use backend\forms\order\RefundForm;
use core\entities\order\Order;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $model RefundForm */
/* @var $order Order */


$this->title = "Возврат по заказу";
\backend\helpers\TemplateHelper::boxWrap($this->params);
$this->params['breadcrumbs'][] = ['label' => 'Заказы', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => '#' . $order->getId(), 'url' => ['view', 'id' => $order->getId()]];
$this->params['breadcrumbs'][] = $this->title;

$this->registerJsFile("@jsView/order-cancel.js?v=2", ['depends' => \yii\web\JqueryAsset::class]);
?>

<div>
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'quantity')->textInput(['id' => 'quantity']) ?>

    <?= $form->field($model, "refundToBalance")
        ->radioList([0 => "На реквизиты", 1 => "На баланс магазина"], [
            'id' => 'refund-to-balance',
            'unselect' => "bedroom",
            'item' => function ($index, $label, $name, $checked, $value) use ($order) {
                $disallow = $value === 1 && $order->isFromGuest();
                return Html::radio($name, $checked, [
                    'value' => $value,
                    'label' => Html::tag("span", Html::encode($label), ['class' => $disallow ? "text-muted" : null]),
                    'disabled' => $disallow,
                ]);
            }
        ]) ?>

    <?= $form->field($model, "bill", [
        'options' => ['id' => 'field-bill', 'style' => 'display:none'],
        'enableClientValidation' => false,
    ])->textInput(['placeholder' => '4335931690293885']) ?>

    <?= $form->field($model, "comment")->textarea(['placeholder' => "Куда возврат?\nПочему?"]) ?>

    <div class="form-group">
        <?= Html::submitButton('Возврат', ['class' => 'btn btn-lg btn-warning']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
