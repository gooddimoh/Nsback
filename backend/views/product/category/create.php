<?php

/* @var $this yii\web\View */
/* @var $model \core\entities\product\Category */

$this->title = 'Новая категория';
$this->params['breadcrumbs'][] = ['label' => 'Категория', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\backend\helpers\TemplateHelper::boxWrap($this->params);
?>
<div>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
