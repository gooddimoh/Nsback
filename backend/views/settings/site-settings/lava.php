<?php

/**
 * @var $model LavaSettingsForm
 */

use core\forms\settings\LavaSettingsForm;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Lava';
?>

<div class="col-md-2"><?= $this->render('_payment-menu') ?></div>
<div class="col-md-10">
    <div class="box">
        <div class="box-body">
            <?php $form = ActiveForm::begin() ?>

            <?= $form->field($model, 'jwtToken')->passwordInput() ?>
            <?= $form->field($model, 'walletTo') ?>

            <?= $form->field($model, 'description')->textarea() ?>

            <?= $form->field($model, 'disable')->checkbox() ?>

            <div class="form-group">
                <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
            </div>

            <?php ActiveForm::end() ?>

        </div>
    </div>
</div>
