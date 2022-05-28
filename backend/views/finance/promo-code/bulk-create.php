<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model \core\forms\order\promo\PromoCodeBulkForm */

$this->title = 'Массовое добавление';
$this->params['breadcrumbs'][] = ['label' => 'Промо-коды', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="promo-code-create">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'codes')->textarea() ?>

    <?= $form->field($model, 'percent') ?>

    <?= $form->field($model, 'comment')->textInput() ?>

    <?= $form->field($model, 'activationLimit')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' =>'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
