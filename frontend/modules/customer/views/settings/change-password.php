<?php

use core\forms\user\ChangeMyPasswordForm;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var $model ChangeMyPasswordForm
 * @var $this \yii\web\View
 */

$this->title = "Сменить пароль";
$this->params['breadcrumbs'][] = ['label' => 'Настройки'];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row">
    <div class="col-md-2">
        <?= $this->render("_menu") ?>
    </div>
    <div class="col-md-6">
        <?php $form = ActiveForm::begin() ?>

        <?= $form->field($model, 'password')->passwordInput() ?>
        <?= $form->field($model, 'newPassword')->passwordInput() ?>
        <?= $form->field($model, 'newPasswordRepeat')->passwordInput() ?>

        <div class="form-group">
            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end() ?>
    </div>
</div>
