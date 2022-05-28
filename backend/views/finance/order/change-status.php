<?php

use core\entities\order\Order;
use core\forms\order\OrderStatusForm;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;
use core\helpers\order\OrderHelper;

/**
 * @var $model OrderStatusForm
 * @var $this View
 * @var $order Order
 */

$this->title = "Смена статуса";
$this->params['breadcrumbs'][] = ['label' => 'Заказы', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => '#' . $order->getId(), 'url' => ['view', 'id' => $order->getId()]];
$this->params['breadcrumbs'][] = $this->title;
\backend\helpers\TemplateHelper::boxWrap($this->params);
?>

<div>
    <?php $form = ActiveForm::begin() ?>

    <?= $form->field($model, 'status')->dropDownList(OrderStatusForm::getStatusList()) ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end() ?>
</div>
