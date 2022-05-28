<?php

/* @var $this yii\web\View */
/* @var $model \core\forms\product\GroupForm */
/* @var $group \core\entities\product\Group */

$this->title = 'Редактирование группы: ' . $group->name;
$this->params['breadcrumbs'][] = ['label' => 'Группы', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $group->name, 'url' => ['view', 'id' => $group->id]];
$this->params['breadcrumbs'][] = 'Редактировать';
\backend\helpers\TemplateHelper::boxWrap($this->params);
?>
<div>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
