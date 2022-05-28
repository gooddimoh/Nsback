<?php

/* @var $this yii\web\View */
/* @var $model ProductForm */
/* @var $rulesTemplates array */

use core\forms\product\ProductForm;

$this->title = 'Новый товар';
$this->params['breadcrumbs'][] = ['label' => 'Товары', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\backend\helpers\TemplateHelper::boxWrap($this->params);
?>
<div>

    <?= $this->render('_form', [
        'model' => $model,
        'rulesTemplates' => $rulesTemplates,
    ]) ?>

</div>
