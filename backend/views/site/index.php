<?php

use backend\helpers\UrlNavigatorBackend;
use yii\grid\GridView;
use core\entities\order\Order;
use yii\data\ActiveDataProvider;
use core\helpers\product\ProductHelper;
use core\helpers\order\OrderHelper;
use yii\widgets\ListView;
use yii\helpers\Html;


/**
 * @var $this \yii\web\View
 * @var $latestOrderDataProvider ActiveDataProvider
 * @var $recentlyProductDataProvider ActiveDataProvider
 */

$this->title = Yii::$app->name;
?>

<div class="row">
    <div class="col-md-9">
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">Последние заказы</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i>
                    </button>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <?= GridView::widget([
                    'dataProvider' => $latestOrderDataProvider,
                    'columns' => [
                        [
                            'attribute' => 'id',
                            'format' => 'html',
                            'value' => function (Order $model) {
                                return Html::a($model->id, UrlNavigatorBackend::viewOrder($model->id));
                            }
                        ],
                        [
                            'attribute' => 'name',
                            'format' => 'html',
                            'value' => function (Order $model) {
                                return Html::a($model->product->name, ['/product/product/view', 'id' => $model->product_id]);
                            },
                            'label' => 'Товар',
                        ],
                        [
                            'attribute' => 'status',
                            'format' => 'html',
                            'value' => function (Order $model) {
                                return OrderHelper::statusLabel($model->status);
                            }
                        ],
                    ]
                ]) ?>
                <!-- /.table-responsive -->
            </div>
            <!-- /.box-body -->
            <div class="box-footer clearfix">
                <?= Html::a("Посмотреть все заказ", ['/finance/order/index'], ['class' => 'btn btn-sm btn-default btn-flat pull-right']) ?>
            </div>
            <!-- /.box-footer -->
        </div>
    </div>
    <div class="col-md-3">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Недавно добавленные товары</h3>

                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i>
                    </button>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <?= ListView::widget([
                    'dataProvider' => $recentlyProductDataProvider,
                    'options' => [
                        'tag' => 'ul',
                        'class' => 'products-list product-list-in-box',
                    ],
                    'layout' => "{items}",
                    'itemView' => '_product-item',
                    'itemOptions' => [
                        'tag' => false,
                    ],
                ]);
                ?>
            </div>
            <!-- /.box-body -->
            <div class="box-footer text-center">
                <?= Html::a("Все товары", ['/product/product/index'], ['class' => 'uppercase']) ?>
            </div>
            <!-- /.box-footer -->
        </div>
    </div>
</div>