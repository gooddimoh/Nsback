<?php

use core\entities\user\User;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var $this \yii\web\View
 * @var $model \core\forms\user\ChangeUserPasswordForm
 * @var $user User
 */

$this->title = "Смена пароля для: {$user->getEncodedUsername()}";
\backend\helpers\TemplateHelper::boxWrap($this->params);
?>

<div class="change-password">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'newPassword')->input('password'); ?>
    <?= $form->field($model, 'newPasswordRepeat')->input('password'); ?>

    <div class="form-group">
        <?= Html::submitButton('Изменить', ['class' => 'btn btn-info']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
