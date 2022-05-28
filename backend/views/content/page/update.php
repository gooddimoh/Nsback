<?php


/**
 * @var $this \yii\web\View
 * @var $model \core\forms\content\PageForm
 * @var $page \core\entities\content\Page
 */

$this->title = 'Редактирование страницы: ' . $page->title;
$this->params['breadcrumbs'][] = ['label' => 'Страницы', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Редактировать';
\backend\helpers\TemplateHelper::boxWrap($this->params);
?>
<div>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
