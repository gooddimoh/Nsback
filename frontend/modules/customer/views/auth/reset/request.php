<?php

/* @var $this yii\web\View */
/* @var $model PasswordResetRequestForm */

/* @var $this View */

use core\forms\auth\PasswordResetRequestForm;
use yii\helpers\Html;
use yii\web\View;
use yii\bootstrap\ActiveForm;

$this->title = 'Запрос сброса пароля';
?>

<div class="centered-form">
    <h3>Запрос сброса пароля</h3>
    <?php $form = ActiveForm::begin() ?>

    <?= $form->field($model, 'email')->textInput(['autofocus' => true]) ?>

    <?= Html::submitButton('Подтвердить', ['class' => 'btn btn-primary']) ?>

    <hr>
    <?= Html::a('Зарегистрироваться', ['/customer/auth/signup/request']) ?> ||
    <?= Html::a('Авторизоваться', ['/customer/auth/auth/login']) ?>

    <?php ActiveForm::end() ?>
</div>