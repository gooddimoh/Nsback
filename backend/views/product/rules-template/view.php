<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/**
 * @var $model \core\entities\product\RulesTemplate
 * @var $this yii\web\View
 */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Шаблоны ответов', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\backend\helpers\TemplateHelper::boxWrap($this->params);
?>
<div class="template-view">
    <p>
        <?= Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы уверены, что хотите удалить шаблон?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'content:html',
        ],
    ]) ?>

</div>
