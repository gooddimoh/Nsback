<?php

use core\entities\product\Product;
use core\forms\product\ProductStatusForm;
use core\helpers\product\ProductHelper;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;

/**
 * @var $model ProductStatusForm
 * @var $this View
 * @var $product Product
 */

$this->title = "Изменить статус товара";
$this->params['breadcrumbs'][] = ['label' => 'Товары', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $product->getEncodedName(), 'url' => \backend\helpers\UrlNavigatorBackend::viewProduct($product->id)];
$this->params['breadcrumbs'][] = $this->title;
?>

<div>
    <?php $form = ActiveForm::begin() ?>

    <p>
       Текущий статус: <?= ProductHelper::statusLabel($product->status) ?>
    </p>

    <?= $form->field($model, 'status')->dropDownList(ProductStatusForm::getStatusList(), ['prompt' => '']) ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end() ?>
</div>
