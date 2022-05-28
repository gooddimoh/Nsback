<?php

use core\forms\user\UserUpdateForm;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var $model UserUpdateForm
 * @var $this \yii\web\View
 * @var $user \core\entities\user\User
 */

$this->title = "Редактировать пользователя: {$user->getEncodedUsername()}";
$this->params['breadcrumbs'][] = ['label' => 'Пользователи', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div>
    <?php $form = ActiveForm::begin() ?>

    <?= $form->field($model, 'username') ?>

    <?= $form->field($model, 'email') ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end() ?>
</div>
