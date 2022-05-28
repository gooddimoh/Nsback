<?php

use core\entities\product\Product;
use core\forms\product\ProductForm;
use yii\helpers\Html;
use yii\web\View;

/**
 * @var $this View
 * @var $model ProductForm
 * @var $product Product
 * @var $rulesTemplates array
 */

$this->title = Html::encode($product->name);
$this->params['breadcrumbs'][] = ['label' => 'Товары', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => \backend\helpers\UrlNavigatorBackend::viewProduct($product->id)];
$this->params['breadcrumbs'][] = 'Редактировать';
\backend\helpers\TemplateHelper::boxWrap($this->params);
?>
<div>

    <?= $this->render('_form', [
        'model' => $model,
        'rulesTemplates' => $rulesTemplates,
        'product' => $product,
    ]) ?>

</div>
