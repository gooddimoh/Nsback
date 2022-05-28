<?php


/**
 * @var $this \yii\web\View
 * @var $model \core\forms\product\CategoryForm
 * @var $category \core\entities\product\Category
 */

$this->title = 'Редактирование категории: ' . $category->name;
$this->params['breadcrumbs'][] = ['label' => 'Категории', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $category->name, 'url' => ['view', 'id' => $category->id]];
$this->params['breadcrumbs'][] = 'Редактировать';
\backend\helpers\TemplateHelper::boxWrap($this->params);
?>
<div>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
