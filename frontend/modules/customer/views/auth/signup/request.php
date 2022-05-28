<?php

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */

/* @var $model SignupForm */

use core\forms\auth\SignupForm;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Регистрация';
?>

<div class="centered-form">
    <h3>Регистрация</h3>
    <?php $form = ActiveForm::begin() ?>

    <!-- form -->
    <?= $form
        ->field($model, 'username')
        ->label(false)
        ->textInput(['placeholder' => $model->getAttributeLabel('username')])
    ?>

    <?= $form
        ->field($model, 'email')
        ->label(false)
        ->input('email', ['placeholder' => $model->getAttributeLabel('email')])
    ?>

    <?= $form
        ->field($model, 'password')
        ->label(false)
        ->passwordInput(['placeholder' => $model->getAttributeLabel('password')]) ?>

    <?= Html::submitButton('Регистрация', ['class' => 'btn btn-primary btn-block']) ?>
    <hr>
    <?= Html::a('Есть аккаунт?', ['/customer/auth/auth/login']) ?>

    <?php ActiveForm::end(); ?>
    <!-- ./ form -->
</div>

