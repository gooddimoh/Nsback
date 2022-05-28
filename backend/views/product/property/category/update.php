<?php

/**
 * @var $category PropertyCategory
 * @var $model PropertyCategoryForm
 * @var $this yii\web\View
 */

use core\entities\Product\Property\PropertyCategory;
use core\forms\product\property\PropertyCategoryForm;

$this->title = 'Редактировать: ' . $category->name;
$this->params['breadcrumbs'][] = ['label' => 'Категории свойств', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $category->name, 'url' => ['view', 'id' => $category->id]];
$this->params['breadcrumbs'][] = 'Редактировать';
?>
<div>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
