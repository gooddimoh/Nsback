<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var $model \core\forms\settings\QiwiInvoiceForm
 */

$this->title = 'Qiwi Invoice';
?>

<div class="row">
    <div class="col-md-2"><?= $this->render('_payment-menu') ?></div>
    <div class="col-md-8">
        <div class="box">
            <div class="box-body">
                <?php $form = ActiveForm::begin() ?>

                <?= $form->field($model, 'publicKey')->textInput(['id' => 'publicKey']) ?>
                <?= $form->field($model, 'secretKey')->passwordInput(['id' => 'secretKey']) ?>

                <?= $form->field($model, 'description')->textarea() ?>
                <?= $form->field($model, 'disabled')->checkbox() ?>

                <div class="form-group">
                    <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
                </div>

                <?php ActiveForm::end() ?>
            </div>
        </div>
    </div>
</div>