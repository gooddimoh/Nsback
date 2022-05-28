<?php

use core\forms\settings\MainSettingsForm;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var $model MainSettingsForm
 */


$this->title = 'Основные настройки';
?>

<div class="col-md-2"><?= $this->render('_payment-menu') ?></div>
<div class="col-md-10">
    <div class="box">
        <div class="box-body">
            <?php $form = ActiveForm::begin() ?>

            <h3>Глобальные настройки</h3>

            <?= $form->field($model, 'headCode')->textarea() ?>
            <?= $form->field($model, 'endBodyCode')->textarea() ?>

            <h3>Отключение сайта</h3>
            <?= $form->field($model, 'disableSiteMessage')->textarea() ?>
            <?= $form->field($model, 'disableSite')->checkbox() ?>

            <?= $form->field($model, 'disableProductUpdate')->checkbox() ?>

            <div class="form-group">
                <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
            </div>

            <?php ActiveForm::end() ?>
        </div>
    </div>
</div>