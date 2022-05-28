<?php

use backend\helpers\TemplateHelper;
use core\entities\product\Product;
use core\forms\product\ProductMetaForm;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\web\View;

/**
 * @var $model ProductMetaForm
 * @var $this View
 * @var $product Product
 */

$this->title = "Редактирование Meta";
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => \backend\helpers\UrlNavigatorBackend::viewProduct($product->id)];
$this->params['breadcrumbs'][] = 'Редактировать';
TemplateHelper::boxWrap($this->params);
?>

<div>
    <?php $form = ActiveForm::begin() ?>

    <?= $form->field($model, 'title') ?>

    <?= $form->field($model, 'description')->textarea() ?>

    <?= $form->field($model, 'keywords')->textarea() ?>

    <?php if (!empty($product->productImport)): ?>
        <?= $form->field($model, 'disableImportChange')->checkbox() ?>
    <?php endif; ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end() ?>

</div>
