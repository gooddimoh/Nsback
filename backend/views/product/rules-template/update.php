<?php

/**
 * @var $model \core\forms\product\RulesTemplateForm
 * @var $template \core\entities\product\RulesTemplate
 * @var $this yii\web\View
 */

$this->title = 'Редактирование шаблона: ' . $template->name;
$this->params['breadcrumbs'][] = ['label' => 'Шаблоны ответов', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $template->name, 'url' => ['view', 'id' => $template->id]];
$this->params['breadcrumbs'][] = 'Редактировать';
\backend\helpers\TemplateHelper::boxWrap($this->params);
?>
<div class="template-update">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
