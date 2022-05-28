<?php

use backend\forms\shop\CouponSearch;
use backend\helpers\UrlNavigatorBackend;
use core\entities\shop\Coupon;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel CouponSearch */

$this->title = 'Купоны';
$this->params['breadcrumbs'][] = $this->title;
\backend\helpers\TemplateHelper::boxWrap($this->params);
?>
<div>
    <p>
        <?= Html::a('Добавить купон', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'id',
            [
                'attribute' => 'shop_id',
                'value' => function (Coupon $model) {
                    return Html::a($model->shop->name, UrlNavigatorBackend::viewShop($model->shop_id));
                },
                'filter' => CouponSearch::shopList()
            ],
            [
                'attribute' => 'percent',
                'value' => function (Coupon $model) {
                    return "{$model->percent}%";
                }
            ],
            [
                'attribute' => 'code',
            ],
            [
                'attribute' => 'comment',
                'value' => function (Coupon $model) {
                    return StringHelper::truncate($model->comment, 60);
                }
            ],


            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
