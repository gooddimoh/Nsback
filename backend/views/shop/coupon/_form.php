<?php

use core\forms\shop\CouponForm;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var $this yii\web\View
 * @var $form yii\widgets\ActiveForm
 * @var $model CouponForm
 */
?>

<div>
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'shopId')->dropDownList(CouponForm::getShopList()) ?>

    <?= $form->field($model, 'percent') ?>

    <?= $form->field($model, 'code') ?>

    <?= $form->field($model, 'comment')->textarea() ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
