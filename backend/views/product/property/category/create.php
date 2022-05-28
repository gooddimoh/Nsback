<?php

/* @var $this yii\web\View */
/* @var $model PropertyCategoryForm */

use core\forms\product\property\PropertyCategoryForm;

$this->title = 'Новая категория свойств';
$this->params['breadcrumbs'][] = ['label' => 'Категории свойств', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
