<?php

/* @var $this yii\web\View */
/* @var $model \core\entities\content\Page */

$this->title = 'Новая страница';
$this->params['breadcrumbs'][] = ['label' => 'Страницы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\backend\helpers\TemplateHelper::boxWrap($this->params);
?>

<div class="alert alert-info">
    Чтобы разместить страницу на сайте - обратитесь к разработчику после её добавления.
</div>
<div>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
