<?php

/* @var $this yii\web\View */
/* @var $model PropertyForm */

use core\forms\product\property\PropertyForm;

$this->title = 'Новое свойство';
$this->params['breadcrumbs'][] = ['label' => 'Свойства', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
