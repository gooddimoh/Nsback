<?php

use backend\helpers\GroupList;
use core\forms\product\ProductForm;
use core\widgets\DynamicGridviewSize;
use yii\data\ActiveDataProvider;
use yii\grid\ActionColumn;
use yii\grid\CheckboxColumn;
use yii\grid\GridView;
use core\entities\product\Product;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;
use core\helpers\product\ProductHelper;
use backend\forms\product\ProductSearch;

/**
 * @var $dataProvider ActiveDataProvider
 * @var $this View
 * @var $searchModel ProductSearch
 */

$this->title = "Товары";
\backend\helpers\TemplateHelper::boxWrap($this->params);
$js = <<<JS

if (getDocumentCookie("orderSearchDisplay")) {
    $("#product-search-form").show();
}

$("#search-form-control").on("click", function (e) {
    setDocumentCookie("orderSearchDisplay", !$('#product-search-form').is(':visible'));
    $("#product-search-form").toggle();
});
JS;

$this->registerJs($js, View::POS_READY);
?>
<p class="pull-left">
    <?= Html::a("Новый товар", ['create'], ['class' => 'btn btn-success']) ?>
</p>
<div class="pull-right">
    <?php echo DynamicGridviewSize::widget(['dataProvider' => $dataProvider]) ?>
</div>

<div class="clearfix"></div>
<p>
    <a href="#" id="search-form-control">Показать/скрыть форму поиска</a>
</p>
<div class="box box-info" id="product-search-form" style="display: none;">
    <div class="box-header with-border">
        <div class="box-title">Поиск</div>
    </div>
    <div class="box-body">
        <?php $form = ActiveForm::begin([
            'method' => 'get',
            'options' => [
                'class' => 'order-search',
            ]
        ]); ?>

        <div class="row">
            <div class="col-md-1">
                <?= $form->field($searchModel, 'id') ?>
            </div>
            <div class="col-md-3">
                <?= $form->field($searchModel, 'name') ?>
            </div>
            <div class="col-md-3">
                <?= $form->field($searchModel, 'description') ?>
            </div>
            <div class="col-md-1">
                <?= $form->field($searchModel, 'status')->dropDownList(ProductHelper::statusList(), ['prompt' => '']) ?>
            </div>
            <div class="col-md-1">
                <?= $form->field($searchModel, 'group_id')->dropDownList(GroupList::get(), ['prompt' => '']) ?>
            </div>
            <div class="col-md-1">
                <?= $form->field($searchModel, 'shop_id')->dropDownList(ProductSearch::getShopList(), ['prompt' => '']) ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <?php foreach ($searchModel::getPropertyCategoryList() as $category):?>
                    <p>
                        <b><?= $category->name ?></b>
                    </p>
                    <?php foreach ($category->properties as $property): ?>
                        <?= $form->field($searchModel, 'properties[]', ['options' => ['tag' => 'div', 'class' => 'inline-block']])
                            ->checkbox([
                                'value' => $property->id,
                                'label' => $property->name,
                                'uncheck' => null,
                                'checked' => $searchModel->isPropertyExists($property->id),
                            ]) ?>
                    <?php endforeach; ?>
                <?php endforeach; ?>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="form-group" style="padding-top: 15px;">
            <?= Html::submitButton('Искать', ['class' => 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>
<div class="clearfix"></div>

<div class="box box-info">
    <div class="box-body">
        <?= Html::beginForm(['bulk'], 'post', ['class' => 'form form-inline']); ?>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                ['class' => CheckboxColumn::class],
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
                        return "{$model->group->category->name}: " .  Html::a("{$model->group->name}", ["/product/group/view", 'id' => $model->group_id]);
                    },
                    'label' => 'Принадлежность',
                ],
                [
                    'attribute' => 'shop',
                    'value' => function (Product $model) {
                        return !empty($model->productImport->shop) ? $model->productImport->shop->name : null;
                    },
                    'label' => 'Магазин',
                ],
                'name',
                'price:currency',
                'minimum_order',
                'quantity',
                [
                    'attribute' => 'status',
                    'format' => 'html',
                    'value' => function (Product $model) {
                        return ProductHelper::statusLabel($model->status);
                    }
                ],
                ['class' => ActionColumn::class],
            ]
        ]) ?>
        <div class="pull-right">
            <div class="form-group">
                <?= Html::dropDownList(
                    'action',
                    '',
                    [
                        'show' => 'Отобразить',
                        'hide' => 'Скрыть',
                        'updateBulk' => 'Редактировать',
                        'delete' => 'Удалить',
                    ],
                    ['class' => 'form-control', 'prompt' => 'Выберите действие']
                ) ?>
            </div>
            <div class="form-group">
                <?= Html::submitButton('Отправить', ['class' => 'btn btn-info']); ?>
            </div>
            <div class="clearfix"></div>
        </div>
        <?= Html::endForm() ?>
    </div>
</div>