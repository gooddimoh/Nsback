<?php

use core\entities\Product\Property\PropertyCategory;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\StringHelper;


/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Категории свойств';
$this->params['breadcrumbs'][] = $this->title;
?>
<div>
    <p>
        <?= Html::a('Новая категория', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'name',
            [
                'attribute' => 'description',
                'value' => function (PropertyCategory $model) {
                    return StringHelper::truncate($model->description, 125);
                }
            ],

            [
                'class' => \yii\grid\ActionColumn::class,
                'template' => '{view} {update}',
            ],
        ],
    ]) ?>
</div>

