<?php

use core\entities\Product\Property\Property;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\StringHelper;


/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Свойства';
$this->params['breadcrumbs'][] = $this->title;
?>
<div>
    <p>
        <?= Html::a('Новое свойство', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            [
                'attribute' => 'category_id',
                'value' => function (Property $model) {
                    return $model->category->name;
                }
            ],
            'name',
            [
                'attribute' => 'description',
                'value' => function (Property $model) {
                    return StringHelper::truncate($model->description, 125);
                }
            ],

            [
                'class' => \yii\grid\ActionColumn::class,
            ],
        ],
    ]) ?>
</div>

