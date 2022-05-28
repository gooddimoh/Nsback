<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use core\forms\product\GroupForm;

/* @var $this yii\web\View */
/* @var $model GroupForm */
/* @var $form yii\widgets\ActiveForm */
?>

<div>
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'categoryId')->dropDownList(GroupForm::getCategoryList()) ?>

    <?= $form->field($model, 'slug')->textInput() ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <h3>SEO</h3>
    <div class="row">
        <div class="col-md-12">
            <?= $form->field($model, 'seoTitle')->textInput() ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'seoKeywords')->textarea() ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'seoDescription')->textarea() ?>
        </div>
    </div>


    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
