<?php

use core\entities\product\Category;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model Category */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Категории', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\backend\helpers\TemplateHelper::boxWrap($this->params);
?>
<div>
    <p>
        <?= Html::a('Редактирование', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            [
                'attribute' => 'icon',
                'format' => 'html',
                'value' => function (Category $model) {
                    return Html::img($model->getIconUrl(), ['style' => 'max-width: 50px;']);
                }
            ],
            'slug',
            'meta_title',
            'meta_keywords',
            'meta_description',
        ],
    ]) ?>

</div>
