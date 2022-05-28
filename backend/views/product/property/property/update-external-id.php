<?php

use core\entities\Product\Property\Property;
use core\forms\product\property\PropertyExternalIdForm;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $model PropertyExternalIdForm */
/* @var $property Property */

$this->title = "Внешний ID";
$this->params['breadcrumbs'][] = ['label' => 'Свойства', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $property->name, 'url' => ['view', 'id' => $property->id]];
$this->params['breadcrumbs'][] = $this->title;
?>

<div>
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'external_id') ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
