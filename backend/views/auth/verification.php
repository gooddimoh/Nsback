<?php

use core\forms\auth\TwoFactorForm;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $model TwoFactorForm */
/* @var $hash string */

$this->title = "Верификация";
?>

<div>
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'verifyCode')->textInput() ?>

    <?= $form->field($model, 'rememberMe')->checkbox() ?>


    <div class="form-group">
        <?= Html::submitButton('Войти', ['class' => 'btn btn-primary btn-block btn-flat', 'name' => 'login-button']) ?>
    </div>
    <?php ActiveForm::end(); ?>

    <p class="text-muted">
        Если код не пришел - отправьте его <?= Html::a("ещё раз", ['verification-resend', 'hash' => $hash], ['data' => ['method' => 'POST']]) ?>
    </p>
</div>
