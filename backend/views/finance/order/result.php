<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var $model \core\forms\order\OrderResultForm
 * @var $this \yii\web\View
 * @var $order \core\entities\order\Order
 */

$this->title = "Запись результата";
$this->params['breadcrumbs'][] = ['label' => 'Заказы', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => '#' . $order->getId(), 'url' => ['view', 'id' => $order->getId()]];
$this->params['breadcrumbs'][] = $this->title;
\backend\helpers\TemplateHelper::boxWrap($this->params);
?>

<div>
    <?php $form = ActiveForm::begin() ?>

    <?= $form->field($model, 'result')->textarea() ?>

    <?= $form->field($model, 'clearError')->checkbox() ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?><br>
        <span class="text-muted">Статус заказа будет "Завершен" после сохранения.</span>
    </div>

    <?php ActiveForm::end() ?>
</div>
