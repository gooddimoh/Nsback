<?php

use backend\helpers\UrlNavigatorBackend;
use yii\helpers\Html;
use yii\widgets\DetailView;
use core\entities\product\Product;
use core\helpers\product\ProductHelper;
use core\entities\product\ProductImport;

/**
 * @var $this \yii\web\View
 * @var $model Product
 */

$this->title = Html::encode($model->name);
$this->params['breadcrumbs'][] = ['label' => 'Товары', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['boxWrap'] = false;
?>
<div>
    <div class="control">
        <div class="pull-left">
            <div class="btn-group btn-group-inline">
                <?= Html::a('Основная информация', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
            </div>
            <div class="btn-group btn-group-inline">
                <div class="dropdown">
                    <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="true">
                        Редактирование
                        <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                        <li><?= Html::a('Статус', ['status', 'id' => $model->id]) ?></li>
                        <li><?= Html::a('Meta', ['meta', 'id' => $model->id]) ?></li>
                        <li><?= Html::a('URL', ['url', 'id' => $model->id]) ?></li>
                    </ul>
                </div>
            </div>

            <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Вы уверены, что хотите удалить данный товар?',
                    'method' => 'post',
                ],
            ]) ?>

        </div>
        <div class="pull-right">
            <?php echo $model->productImport ?
                Html::a("Настройки импорта", ['update-import', 'id' => $model->id], ['class' => 'btn btn-info']) :
                Html::a("Добавить импорт", ['add-import', 'id' => $model->id], ['class' => 'btn btn-info'])
            ?>
        </div>
    </div>
    <div class="clearfix"></div>

    <div class="box" style="margin-top: 15px;">
        <div class="box-body">
            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    [
                        'attribute' => 'miniature',
                        'format' => 'html',
                        'value' => function (Product $model) {
                            return Html::img($model->getMiniature(), ['style' => 'max-width: 50px;']);
                        }
                    ],
                    'id',
                    [
                        'attribute' => 'group_id',
                        'format' => 'html',
                        'value' => function (Product $model) {
                            return Html::a($model->group->name, UrlNavigatorBackend::viewGroup($model->group_id));
                        }
                    ],
                    'name',
                    [
                        'format' => "raw",
                        'value' => function (Product $product) {
                            $url = Yii::$app->frontendUrlManager->createAbsoluteUrl(['products/view', 'slug' => $product->slug], "https");
                            return Html::a($url, $url, ['target' => '_blank']);
                        },
                        'label' => 'Ссылка в магазине',
                    ],
                    'price',
                    'minimum_order',
                    'quantity',
                    [
                        'attribute' => 'properties',
                        'value' => function (Product $model) {
                            return $model->getPropertyAsString();
                        }
                    ],
                    [
                        'attribute' => 'status',
                        'format' => 'html',
                        'value' => function (Product $model) {
                            return ProductHelper::statusLabel($model->status);
                        }
                    ],
                    'purchase_counter',
                    'is_top:boolean',
                ],
            ]) ?>
        </div>
    </div>

    <?php if ($model->productImport): ?>
        <div class="box">
            <div class="box-header">
                <div class="box-title">
                    Импорт
                </div>
            </div>
            <div class="box-body">
                <?= DetailView::widget([
                    'model' => $model->productImport,
                    'attributes' => [
                        [
                            'attribute' => 'shop_id',
                            'format' => 'html',
                            'value' => function (ProductImport $model) {
                                return Html::a($model->shop->name, ['/shop/shop/view', 'id' => $model->shop_id]);
                            }
                        ],
                        'shop_item_id',
                        'own_miniature:boolean',
                        'own_name:boolean',
                        'own_description:boolean',
                        'own_meta:boolean',
                        'created_at:dateTime',
                        'updated_at:dateTime',
                    ],
                ]) ?>
            </div>
        </div>
    <?php endif; ?>

    <?php if ($model->productMeta): ?>
        <div class="box">
            <div class="box-header">
                <div class="box-title">
                    Meta
                </div>
            </div>
            <div class="box-body">
                <?= DetailView::widget([
                    'model' => $model->productMeta,
                    'attributes' => [
                        'description',
                        'keywords',
                    ],
                ]) ?>
            </div>
        </div>
    <?php endif; ?>


</div>
