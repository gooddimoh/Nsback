<?php

use backend\helpers\TemplateHelper;
use backend\helpers\UrlNavigatorBackend;
use rmrevin\yii\fontawesome\FontAwesome;
use yii\grid\GridView;
use core\entities\payment\Payment;
use yii\helpers\Html;
use core\helpers\finance\PaymentHelper;
use backend\forms\finance\PaymentSearch;

/**
 * @var $dataProvider \yii\data\ActiveDataProvider
 * @var $searchModel PaymentSearch
 * @var $this \yii\web\View
 */

$this->title = "Платежи";
TemplateHelper::boxWrap($this->params);
?>

<div>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'id',
            'sum:currency',
            [
                'attribute' => 'order_id',
                'format' => 'html',
                'value' => function (Payment $model) {
                    if ($model->isTypeOrder()) {
                        return Html::a($model->paymentOrder->order_id, UrlNavigatorBackend::viewOrder($model->paymentOrder->order_id));
                    }

                    return null;
                },
                'label' => 'Заказ',
            ],
            [
                'attribute' => 'user_id',
                'format' => 'html',
                'value' => function (Payment $model) {
                    if ($model->isTypeDeposit()) {
                        return Html::a($model->paymentDeposit->user_id, UrlNavigatorBackend::viewUser($model->paymentDeposit->user_id));
                    }

                    return null;
                },
                'label' => 'Пополнение',
            ],
            [
                'attribute' => 'type',
                'value' => function (Payment $model) {
                    try {
                        return PaymentHelper::typeName($model->getType());
                    } catch (\LogicException $exception) {
                        return $exception->getMessage();
                    }
                },
                'filter' => PaymentHelper::typeList(),
                'label' => 'Тип',
            ],
            [
                'attribute' => 'method',
                'value' => function (Payment $model) {
                    return PaymentHelper::methodName($model->method);
                },
                'filter' => PaymentHelper::methodList(),
            ],
            [
                'attribute' => 'status',
                'format' => 'html',
                'value' => function (Payment $model) {
                    return PaymentHelper::statusLabel($model->status);
                },
                'filter' => PaymentHelper::statusList(),
            ],
            'created_at:date',
            'paid_at:date',
            [
                'class' => \yii\grid\ActionColumn::class,
                'template' => '{paid} {cancel}',
                'buttons' => [
                    'paid' => function ($url, Payment $model) {
                        if ($model->isStatusUnpaid()) {
                            return Html::a(FontAwesome::icon("check"), ['paid', 'id' => $model->id], [
                                'data' => [
                                    'confirm' => 'Вы уверены, что пользователь действительно оплатил платеж?',
                                    'method' => 'POST',
                                ]
                            ]);
                        }

                        return null;
                    },
                    'cancel' => function ($url, Payment $model) {
                        if ($model->isStatusUnpaid()) {
                            return Html::a(FontAwesome::icon("close"), ['cancel', 'id' => $model->id], [
                                'data' => [
                                    'confirm' => 'Вы уверены, что пользователь действительно оплатил платеж?',
                                    'method' => 'POST',
                                ]
                            ]);
                        }

                        return null;
                    }
                ],
            ],
        ]
    ]) ?>
</div>