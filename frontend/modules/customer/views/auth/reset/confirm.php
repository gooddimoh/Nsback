<?php

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */

/* @var $model ResetPasswordForm */

use core\forms\auth\ResetPasswordForm;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Сброс пароля';
?>
<div class="site-reset-password">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Введите Ваш новый пароль:</p>

    <div class="centered-form">
        <?php $form = ActiveForm::begin(['id' => 'reset-password-form']); ?>

        <?= $form->field($model, 'password')->passwordInput(['autofocus' => true]) ?>

        <div class="form-group">
            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>
