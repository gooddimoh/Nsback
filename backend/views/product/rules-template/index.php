<?php

use yii\helpers\Html;
use himiklab\sortablegrid\SortableGridView;


/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Шаблоны правил';
$this->params['breadcrumbs'][] = $this->title;
\backend\helpers\TemplateHelper::boxWrap($this->params);
?>
<div class="template">
    <p>
        <?= Html::a('Новый шаблон', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <div class="clearfix"></div>
    <?= SortableGridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'name',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <p class="pull-left text-muted">
        Для изменения порядка вывода элементов - зажмите элемент таблицы и поместите его на нужное место.
    </p>
</div>
