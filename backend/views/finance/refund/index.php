<?php

use backend\forms\finance\RefundSearch;
use backend\helpers\UrlNavigatorBackend;
use core\helpers\order\RefundHelper;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\web\View;
use core\entities\order\Refund;

/* @var $this View */
/* @var $searchModel RefundSearch */
/* @var $dataProvider ActiveDataProvider */

$this->title = "Возвраты";
\backend\helpers\TemplateHelper::boxWrap($this->params);
?>

<div>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'attribute' => 'order_id',
                'format' => 'html',
                'value' => function (Refund $model) {
                    return Html::a("#$model->order_id", UrlNavigatorBackend::viewOrder($model->order_id));
                }
            ],
            [
                'attribute' => 'email',
                'value' => function (Refund $model) {
                    return $model->order->email;
                }
            ],
            [
                'attribute' => 'user_id',
                'value' => function (Refund $model) {
                    return $model->order->user_id;
                },
                'label' => 'ID Пользователя',
            ],
            [
                'attribute' => 'bill',
                'value' => function (Refund $model) {
                    return $model->isRefundToBalance() ? "-" : $model->bill;
                }
            ],
            'refund_to_balance:boolean',
            [
                'attribute' => 'type',
                'value' => function (Refund $model) {
                    return RefundHelper::typeName($model->type);
                },
                'filter' => RefundHelper::typeList(),
            ],
            'sum:currency',
            'quantity',
            'comment',
            'created_at:dateTime',
        ]
    ]) ?>
</div>