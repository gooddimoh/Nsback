<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use core\forms\product\ProductCreateImportForm;

/**
 * @var $product \core\entities\product\Product
 * @var $createForm \core\forms\product\ProductCreateImportForm
 * @var $settingsForm \core\forms\product\ProductImportForm
 * @var $this \yii\web\View
 */

$this->title = "Создать настройки импорта для " . $product->getEncodedName();
$this->params['breadcrumbs'][] = ['label' => 'Импорт', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $product->getEncodedName(), 'url' => \backend\helpers\UrlNavigatorBackend::viewProduct($product->id)];
$this->params['breadcrumbs'][] = $this->title;
\backend\helpers\TemplateHelper::boxWrap($this->params);
?>

<div>
    <?php $form = ActiveForm::begin() ?>

    <?= $form->field($createForm, 'shopId')->dropDownList(ProductCreateImportForm::getShopList()) ?>

    <?= $form->field($createForm, 'shopItemId') ?>

    <div class="row">
        <div class="col-md-2"><?= $form->field($settingsForm, 'ownMiniature')->checkbox() ?> </div>
        <div class="col-md-2"><?= $form->field($settingsForm, 'ownName')->checkbox() ?> </div>
        <div class="col-md-2"><?= $form->field($settingsForm, 'ownDescription')->checkbox() ?></div>
        <div class="col-md-2"><?= $form->field($settingsForm, 'ownSeo')->checkbox() ?></div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end() ?>
</div>
