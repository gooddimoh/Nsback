<?php

/**
 * @var $model \core\forms\settings\FreekassaSettingsForm
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Freekassa';
?>

<div class="col-md-2"><?= $this->render('_payment-menu') ?></div>
<div class="col-md-10">
    <div class="box">
        <div class="box-body">
            <?php $form = ActiveForm::begin() ?>

            <?= $form->field($model, 'shopId') ?>
            <?= $form->field($model, 'firstKey')->passwordInput() ?>
            <?= $form->field($model, 'secondKey')->passwordInput() ?>

            <?= $form->field($model, 'description')->textarea() ?>

            <?= $form->field($model, 'disable')->checkbox() ?>

            <div class="form-group">
                <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
            </div>

            <?php ActiveForm::end() ?>
        </div>
    </div>
</div>