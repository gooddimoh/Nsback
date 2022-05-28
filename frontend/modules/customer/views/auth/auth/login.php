<?php

use core\forms\auth\LoginForm;
use yii\helpers\Html;
use yii\web\View;
use yii\bootstrap\ActiveForm;

/**
 * @var $this View
 * @var $model LoginForm
 */

$this->title = "Авторизация";
?>

<div class="centered-form">
    <h2>Авторизация</h2>

    <!-- form -->
    <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
    <?= $form
        ->field($model, 'username')
        ->label(false)
        ->textInput(['placeholder' => $model->getAttributeLabel('username')]) ?>

    <?= $form
        ->field($model, 'password')
        ->label(false)
        ->passwordInput(['placeholder' => $model->getAttributeLabel('password')]) ?>

    <div class="form-group d-flex justify-content-between">
        <div class="custom-control custom-checkbox">
            <?= $form->field($model, 'rememberMe')->checkbox() ?>
        </div>
    </div>
    <?= Html::submitButton('Войти', ['class' => 'btn btn-primary']) ?>

    <hr>
    <b><?= Html::a('Создать аккаунт', ['/customer/auth/signup/request']) ?></b> |
    <?= Html::a('Сбросить пароль', ['/customer/auth/reset/request']) ?>

    <?php ActiveForm::end(); ?>

</div>

