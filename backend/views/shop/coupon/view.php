<?php

use backend\helpers\UrlNavigatorBackend;
use core\entities\shop\Coupon;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model Coupon */

$this->title = "Купон №{$model->id} от магазина {$model->shop->name}";
$this->params['breadcrumbs'][] = ['label' => 'Купоны', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div>

    <p>
        <?= Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы уверены, что хотите удалить купон?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            [
                'attribute' => 'shop_id',
                'value' => function (Coupon $model) {
                    return Html::a($model->shop->name, UrlNavigatorBackend::viewShop($model->shop_id));
                },
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
            ],
        ],
    ]) ?>

</div>
