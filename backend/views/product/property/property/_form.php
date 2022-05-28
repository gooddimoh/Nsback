<?php

use core\forms\product\property\PropertyCategoryForm;
use core\forms\product\property\PropertyForm;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $model PropertyForm */
?>

<div>
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'categoryId')->dropDownList(PropertyForm::getCategoryList()) ?>

    <?= $form->field($model, 'name')->textInput() ?>

    <?= $form->field($model, 'description')->textarea() ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
