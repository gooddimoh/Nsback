<?php

/**
 * @var $model \core\forms\settings\EnotSettingsForm
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Enot';
?>

<div class="col-md-2"><?= $this->render('_payment-menu') ?></div>
<div class="col-md-10">
    <div class="box">
        <div class="box-body">
            <?php $form = ActiveForm::begin() ?>

            <?= $form->field($model, 'merchantId') ?>
            <?= $form->field($model, 'firstSecret')->passwordInput() ?>
            <?= $form->field($model, 'secondSecret')->passwordInput() ?>

            <?= $form->field($model, 'description')->textarea() ?>

            <?= $form->field($model, 'disable')->checkbox() ?>

            <div class="form-group">
                <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
            </div>

            <?php ActiveForm::end() ?>
        </div>
    </div>
</div>