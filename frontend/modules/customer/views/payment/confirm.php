<?php

use core\entities\order\Order;
use frontend\helpers\UrlNavigator;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/**
 * @var $this \yii\web\View
 * @var $order Order
 */

$this->title = "Подтверждение заказа: {$order->email}";
?>
<div class="row">
    <div class="col-md-offset-3 col-md-5 col-xs-12">
        <h2 class="text-center">Ваш заказ:</h2>
        <?= DetailView::widget([
            'model' => $order,
            'attributes' => [
                [
                    'attribute' => 'product_id',
                    'format' => 'raw',
                    'value' => function (Order $model) {
                        return Html::a($model->product->getEncodedName(), UrlNavigator::viewProduct($model->product->slug), ['target' => '_blank']);
                    }
                ],
                'email',
                [
                    'attribute' => 'cost',
                    'value' => function (Order $model) {
                        return "{$model->getCost()} руб.";
                    }
                ],
                [
                    'attribute' => 'user_balance',
                    'format' => 'html',
                    'value' => function () {
                        return Html::tag("span", Yii::$app->user->identity->getPrettyBalance(), ['class' => 'label label-success']);
                    },
                    'label' => 'Ваш баланс',
                ],
                'quantity',
            ],
        ]) ?>
        <p class="text-center">
            <?php echo Html::a("Подтвердить", Url::current(), [
                'class' => 'btn btn-lg btn-success',
                'data' => ['confirmed' => "Вы уверены, что хотите подтвердить заказ?", 'method' => 'POST']
            ]) ?>
        </p>
    </div>
</div>
