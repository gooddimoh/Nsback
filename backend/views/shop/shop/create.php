<?php

/* @var $this yii\web\View */
/* @var $model \core\forms\product\GroupForm */

$this->title = 'Новый магазин';
$this->params['breadcrumbs'][] = ['label' => 'Магазины', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\backend\helpers\TemplateHelper::boxWrap($this->params);
?>
<div>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
