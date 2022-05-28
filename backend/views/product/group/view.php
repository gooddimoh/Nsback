<?php

use backend\helpers\UrlNavigatorBackend;
use yii\helpers\Html;
use yii\widgets\DetailView;
use core\entities\product\Group;

/* @var $this yii\web\View */
/* @var $model Group */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Группы', 'url' => ['index']];
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
                'attribute' => 'category_id',
                'format' => 'html',
                'value' => function (Group $group) {
                    return Html::a($group->category->name, UrlNavigatorBackend::viewCategory($group->category_id));
                },
            ],
            'slug',
            'meta_title',
            'meta_keywords',
            'meta_description',
        ],
    ]) ?>

</div>
