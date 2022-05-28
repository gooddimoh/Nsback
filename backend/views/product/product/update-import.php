<?php

use core\entities\product\Product;
use core\forms\product\ProductImportForm;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;

/**
 * @var $product Product
 * @var $model ProductImportForm
 * @var $this View
 */

$this->title = "Редактирование импорта " . $product->getEncodedName();
$this->params['breadcrumbs'][] = ['label' => 'Импорт', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $product->getEncodedName(), 'url' => \backend\helpers\UrlNavigatorBackend::viewProduct($product->id)];
$this->params['breadcrumbs'][] = $this->title;
\backend\helpers\TemplateHelper::boxWrap($this->params);
?>

<div>
    <?php $form = ActiveForm::begin() ?>

    <div class="row">
        <div class="col-md-2"><?= $form->field($model, 'ownMiniature')->checkbox() ?> </div>
        <div class="col-md-2"><?= $form->field($model, 'ownName')->checkbox() ?> </div>
        <div class="col-md-2"><?= $form->field($model, 'ownDescription')->checkbox() ?></div>
        <div class="col-md-2"><?= $form->field($model, 'ownSeo')->checkbox() ?></div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end() ?>
</div>
