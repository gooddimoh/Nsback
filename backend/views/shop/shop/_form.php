<?php

use core\helpers\product\ShopHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model \core\forms\shop\ShopForm */
/* @var $form yii\widgets\ActiveForm */

$this->registerJsFile("@jsView/shop.js?v=8", ['depends' => \yii\web\JqueryAsset::class])
?>

<div>
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'shopMarkup')->textInput(['id' => 'shop-markup']) ?>
    <p>
        <a href="#" id="internal-markup-activator">Наценка уже вшита в стоимость товара</a>
    </p>

    <?= $form->field($model, 'internalMarkup', ['options' => ['id' => 'internal-markup-block']])
        ->textInput() ?>

    <?= $form->field($model, 'platform')->dropDownList(ShopHelper::platformList()) ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
