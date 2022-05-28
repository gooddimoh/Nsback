<?php

use core\helpers\product\ShopHelper;
use yii\helpers\Html;
use core\entities\shop\Shop;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Магазины';
$this->params['breadcrumbs'][] = $this->title;
\backend\helpers\TemplateHelper::boxWrap($this->params);
?>
<div>
    <p class="pull-left">
        <?= Html::a('Новый магазин', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <p class="pull-right">
        <?= Html::a('Промо-коды', ['/shop/coupon/index'], ['class' => 'btn btn-info']) ?>
    </p>
    <div class="clearfix"></div>

    <?= \yii\grid\GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'id',
            'name',
            'shop_markup',
            'internal_markup',
            [
                'attribute' => 'platform',
                'format' => 'html',
                'value' => function (Shop $model) {
                    return ShopHelper::platformName($model->platform);
                }
            ],
            [
                'attribute' => 'status',
                'format' => 'html',
                'value' => function (Shop $model) {
                    return ShopHelper::statusLabel($model->status);
                }
            ],
            [
                'class' => \yii\grid\ActionColumn::class,
                'template' => '{view} {leqshop} {update}',
                'buttons' => [
                    'leqshop' => function ($url, Shop $model) {
                        if ($model->isPlatformLeqshop()) {
                            return Html::a('<i class="glyphicon glyphicon-globe" aria-hidden="true"></i>', ['leqshop', 'id' => $model->id]);
                        }
                        return null;
                    }
                ],
            ],
        ],
    ]); ?>
</div>
