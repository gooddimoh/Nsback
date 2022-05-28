<?php


use core\forms\order\promo\PromoCodeForm;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model PromoCodeForm */

$this->title = 'Новый промо-код';
$this->params['breadcrumbs'][] = ['label' => 'Промо-коды', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="promo-code-create">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'code') ?>

    <?= $form->field($model, 'percent') ?>

    <?= $form->field($model, 'activationLimit') ?>

    <?= $form->field($model, 'comment') ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' =>'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
