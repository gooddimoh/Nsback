<?php

/**
 * @var $property Property
 * @var $model PropertyCategoryForm
 * @var $this yii\web\View
 */

use core\entities\Product\Property\Property;
use core\forms\product\property\PropertyCategoryForm;

$this->title = 'Редактировать: ' . $property->name;
$this->params['breadcrumbs'][] = ['label' => 'Свойства', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $property->name, 'url' => ['view', 'id' => $property->id]];
$this->params['breadcrumbs'][] = 'Редактировать';
?>
<div>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
