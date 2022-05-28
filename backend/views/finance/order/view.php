<?php

use common\rbac\Roles;
use core\entities\product\ProductImport;
use core\entities\payment\Payment;
use core\entities\order\Refund;
use core\helpers\finance\PaymentHelper;
use core\helpers\order\RefundHelper;
use rmrevin\yii\fontawesome\FontAwesome;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
use core\entities\order\Order;
use core\helpers\order\OrderHelper;
use yii\helpers\HtmlPurifier;

/**
 * @var $this \yii\web\View
 * @var $model Order
 */

$this->title = "Заказ #{$model->id}";
$this->params['breadcrumbs'][] = ['label' => 'Заказы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->registerJsFile("/backend/web/js/views/order-view.js", ['depends' => \yii\web\JqueryAsset::class]);
?>

<div class="text-left"></div>
<p class="text-right">
    <?= Html::a("Записать результат", ['result', 'id' => $model->id], ['class' => 'btn btn-info']) ?>

    <?= Html::a("Изменить статус", ['change-status', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>

    <?php if ($model->isCanBeRefundable()): ?>
        <?= Html::a("Возврат", ['refund', 'id' => $model->id], ['class' => 'btn btn-warning']) ?>
    <?php endif; ?>

    <?php if ($model->isFromGuest()): ?>
        <?= Html::a("Привязать к пользователю", ['assign', 'id' => $model->id], ['class' => 'btn btn-default']) ?>
    <?php endif; ?>
</p>

<?php if ($model->error_data): ?>
    <div class="box box-danger">
        <div class="box-header with-border">
            <div class="box-title">Заказ имеет ошибку</div>
            <p class="pull-right">
                <?= Html::a("Очистить",
                    ['clear-error', 'id' => $model->id],
                    ['data' => ['method' => 'POST', 'confirm' => 'Подтвердить?']]) ?>
            </p>
        </div>
        <div class="box-body">
            <div class="well">
                <?= HtmlPurifier::process($model->error_data) ?>
            </div>
        </div>
    </div>
<?php endif; ?>

<?php if ($model->file): ?>
    <div class="box box-success">
        <div class="box-header with-border">
            <div class="box-title">Результаты заказа</div>
        </div>
        <div class="box-body" id="order-result" style="display: none"></div>
        <div class="box-footer">
                <?= Html::button("Показать на странице", ['class' => 'btn btn-sm btn-info', 'id' => 'order-result-toggler', 'data' => ['id' => $model->id]]) ?>
                <?= Html::a("Скачать файл", ['download', 'id' => $model->id], ['class' => 'btn btn-sm btn-success', 'data' => ['method' => 'POST']]) ?>
        </div>
    </div>
<?php endif; ?>

<?php if ($model->refund): ?>
    <div class="box box-warning">
        <div class="box-header with-border">
            <div class="box-title">Детали возврата</div>
        </div>
        <div class="box-body">
            <?= DetailView::widget([
                'model' => $model->refund,
                'attributes' => [
                    'refund_to_balance:boolean',
                    [
                        'attribute' => 'type',
                        'value' => function (Refund $model) {
                            return RefundHelper::typeName($model->type);
                        },
                        'filter' => RefundHelper::typeList(),
                    ],
                    'sum',
                    'quantity',
                    'comment',
                    'created_at:dateTime',
                ],
            ]) ?>
        </div>
    </div>
<?php endif; ?>


<div class="box box-info">
    <div class="box-header with-border">
        <div class="box-title">
            Сообщение поставщику
        </div>
        <a href="#" id="supplier-toggler">[Отобразить]</a>
    </div>
    <div class="box-body" id="supplier-message" style="display: none">
        <div class="well">
            Позиция: (ID: <?= $model->product->productImport->shop_item_id ?>) <?= $model->product->getEncodedName() ?><br>
            Номер инвойса: <?= $model->invoice_id ?>
        </div>
    </div>
</div>

<div class="box">
    <div class="box-header with-border">
        <div class="box-title">Детали заказа</div>
    </div>
    <div class="boxy-body">
        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                'id',
                [
                    'attribute' => 'user_id',
                    'format' => 'html',
                    'value' => function (Order $model) {
                        return $model->user ? Html::a($model->user->username, ['user/view', 'id' => $model->user_id]) : "Гость";
                    }
                ],
                'invoice_id',
                [
                    'attribute' => 'product_id',
                    'format' => 'raw',
                    'value' => function (Order $model) {
                        $description = HtmlPurifier::process($model->product->description);

                        $content[] = Html::a("{$model->product->name}(ID:$model->product_id)", ['product/product/view', 'id' => $model->product_id]);
                        $content[] = FontAwesome::icon("chevron-down", ['id' => 'product-description-toggler', 'style' => 'cursor: progress']);
                        $content[] = Html::tag("div", $description, ['style' => 'max-width:50%; display:none;', 'id' => 'product-description']);

                        return implode(" ", $content);
                    }
                ],
                [
                    'format' => 'raw',
                    'value' => function (Order $model) {
                        return Html::a("Показать ссылку", '#', ['id' => 'show-order-url', 'data-id' => $model->id]);
                    },
                    'label' => 'Страница заказа',
                ],
                'quantity',
                'cost',
                'email',
                'ip',
                [
                    'attribute' => 'status',
                    'format' => 'html',
                    'value' => function (Order $model) {
                        return OrderHelper::statusLabel($model->status);
                    },
                    'filter' => OrderHelper::statusList(),
                ],
                'downloaded_at:dateTime',
                'created_at:dateTime',
            ],
        ]) ?>
    </div>
</div>

<?php if ($model->paymentOrder): ?>
    <div class="box">
        <div class="box-header with-border">
            <div class="box-title">Детали платежа</div>
        </div>
        <div class="boxy-body">
            <?= DetailView::widget([
                'model' => $model->paymentOrder->payment,
                'attributes' => [
                    'id',
                    'sum',
                    [
                        'attribute' => 'method',
                        'value' => function (Payment $model) {
                            return PaymentHelper::methodName($model->method);
                        },
                        'filter' => PaymentHelper::methodList(),
                    ],
                    [
                        'attribute' => 'status',
                        'value' => function (Payment $model) {
                            return PaymentHelper::statusName($model->status);
                        },
                        'filter' => PaymentHelper::statusList(),
                    ],
                    'created_at:dateTime',
                    'paid_at:dateTime',
                ],
            ]) ?>
        </div>
    </div>
<?php endif; ?>

<?php if ($model->product->productImport): ?>
    <div class="box">
        <div class="box-header with-border">
            <div class="box-title">Детали поставщика</div>
        </div>
        <div class="boxy-body">
            <?= DetailView::widget([
                'model' => $model->product->productImport,
                'attributes' => [
                    [
                        'attribute' => 'shop_id',
                        'format' => 'html',
                        'value' => function (ProductImport $model) {
                            return Html::a($model->shop->name, ['/shop/shop/view', 'id' => $model->shop_id]);
                        }
                    ],
                    'shop_item_id',
                ],
            ]) ?>
        </div>
    </div>
<?php endif; ?>
