<?php

use core\entities\Product\Property\PropertyCategory;
use core\forms\product\property\PropertyExternalIdForm;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $model PropertyExternalIdForm */
/* @var $category PropertyCategory */

$this->title = "Внешний ID";
$this->params['breadcrumbs'][] = ['label' => 'Категории свойств', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $category->name, 'url' => ['view', 'id' => $category->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="alert alert-warning">
    Проставление внешнего ID для <u>категорий</u> - необязательно, поскольку магазин самостоятельно определяет к какой
    категории принадлежит метка.
</div>
<div>
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'external_id') ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
