<?php

use core\forms\settings\PayeerSettingsForm;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var $model PayeerSettingsForm
 */

$this->title = 'Payeer';
?>

<div class="col-md-2"><?= $this->render('_payment-menu') ?></div>
<div class="col-md-10">
    <div class="box">
        <div class="box-body">
            <?php $form = ActiveForm::begin() ?>

            <?= $form->field($model, 'secret')->passwordInput() ?>
            <?= $form->field($model, 'merchantId') ?>

            <?= $form->field($model, 'description')->textarea() ?>
            <?= $form->field($model, 'disable')->checkbox() ?>

            <div class="form-group">
                <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
            </div>

            <?php ActiveForm::end() ?>
        </div>
    </div>
</div>

