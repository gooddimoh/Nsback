<?php

use common\rbac\Roles;
use core\helpers\finance\PaymentHelper;
use core\widgets\DynamicGridviewSize;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use core\entities\order\Order;
use core\helpers\order\OrderHelper;
use backend\forms\order\OrderSearch;
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * @var $dataProvider \yii\data\ActiveDataProvider
 * @var $searchModel OrderSearch
 * @var $this \yii\web\View
 * @var $errorQuantity int
 * @var $suspendedQuantity int
 */

$this->title = "Заказы";
$this->params['boxWrap'] = false;
?>

<?php if ($errorQuantity > 0 || $suspendedQuantity > 0): ?>
    <div class="callout callout-warning">
        <h4>Есть необработанные заказы</h4>
        <p>
            Пожалуйста, обработайте данные заказы. Вы можете самостоятельно записать результат в заказы с ошибками.<br>

        </p>
        <ul>
            <?php if ($errorQuantity > 0): ?>
                <li>
                    С ошибками: <?= $errorQuantity ?>
                    <?= Html::a("[показать]", Url::current([$searchModel->formName() . "[status]" => Order::STATUS_ERROR])) ?>
                </li>
            <?php endif; ?>

            <?php if ($suspendedQuantity > 0): ?>
                <li>
                    Приостановлено: <?= $suspendedQuantity ?>
                    <?= Html::a("[показать]", Url::current([$searchModel->formName() . "[status]" => Order::STATUS_SUSPENDED])) ?>
                </li>
            <?php endif; ?>
        </ul>
    </div>
<?php endif; ?>

<div class="box" style="margin-top: 10px">
    <div class="box-header with-border">
        <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
    </div>
    <div class="box-body">
        <div class="pull-left">
            <?php if (Yii::$app->user->can(Roles::ROLE_SUPPORT)): ?>
                <p>
                    <?= Html::a('Искать заказ', ['find-single'], ['class' => 'btn btn-info']); ?>
                </p>
            <?php endif; ?>
        </div>
        <div class="pull-right">
            <?php echo DynamicGridviewSize::widget(['dataProvider' => $dataProvider]) ?>
        </div>
        <div class="clearfix"></div>
        <div>
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    [
                        'attribute' => 'invoice_id',
                        'label' => 'Поставщик№',
                    ],
                    'id',
                    [
                        'attribute' => 'product_id',
                        'format' => 'html',
                        'value' => function (Order $model) {
                            return Html::a($model->product->name, ['/product/product/view', 'id' => $model->product_id]);
                        },
                        'filterInputOptions' => [
                            'class' => 'form-control',
                            'placeholder' => 'Введите ID продукта'
                        ]
                    ],
                    'cost:currency',
                    'quantity',
                    'email',
                    [
                        'attribute' => 'status',
                        'format' => 'html',
                        'value' => function (Order $model) {
                            return OrderHelper::statusLabel($model->status);
                        },
                        'filter' => OrderHelper::statusList(),
                    ],
                    [
                        'attribute' => 'downloaded_at',
                        'format' => 'dateTime',
                    ],
                    [
                        'attribute' => 'method',
                        'value' => function (Order $model) {
                            return PaymentHelper::methodName($model->paymentOrder->payment->method);
                        },
                        'filter' => PaymentHelper::methodList(),
                        'label' => 'Метод',
                    ],
                    'created_at:dateTime',
                    [
                        'class' => \yii\grid\ActionColumn::class,
                        'template' => '{view}',
                        'buttons' => [
                            'view' => function ($url, Order $model) {
                                return Html::a("Детали", ['view', 'id' => $model->getId()]);
                            }
                        ],
                    ],
                ]
            ]) ?>
        </div>
    </div>
</div>