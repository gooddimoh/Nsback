<?php

use core\helpers\communication\BannerHelper;
use yii\helpers\Html;
use yii\grid\GridView;
use core\entities\communication\Banner;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Баннеры';
$this->params['breadcrumbs'][] = $this->title;
?>
<div>
    <p>
        <?= Html::a('Добавить баннер', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'name',
            [
                'attribute' => 'location',
                'value' => function (Banner $model) {
                    return BannerHelper::locationName($model->location);
                }
            ],
            [
                'attribute' => 'is_active',
                'format' => 'html',
                'value' => function (Banner $model) {
                    return BannerHelper::activationLabel($model->is_active);
                }
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
