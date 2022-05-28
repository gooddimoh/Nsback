<?php


/* @var $this yii\web\View */
/* @var $model \core\entities\product\RulesTemplate */

$this->title = 'Новый шаблон';
$this->params['breadcrumbs'][] = ['label' => 'Шаблоны ответов', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\backend\helpers\TemplateHelper::boxWrap($this->params);
?>
<div class="template-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
