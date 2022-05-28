<?php

use backend\forms\product\IncompleteProductSearch;
use backend\helpers\UrlNavigatorBackend;
use yii\grid\CheckboxColumn;
use core\widgets\DynamicGridviewSize;
use yii\helpers\StringHelper;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use core\helpers\product\ProductHelper;
use core\entities\product\Product;
use yii\grid\GridView;

/**
 * @var $dataProvider \yii\data\ActiveDataProvider
 * @var $this \yii\web\View
 * @var $searchModel IncompleteProductSearch
 */

$this->title = "Заполнение товаров";
$js = <<<JS

if (getDocumentCookie("orderSearchDisplay")) {
    $("#fill-search-form").show();
}

$("#search-form-control").on("click", function (e) {
    setDocumentCookie("orderSearchDisplay", !$('#fill-search-form').is(':visible'));
    $("#fill-search-form").toggle();
});
JS;

$this->registerJs($js, \yii\web\View::POS_READY);
?>

<div class="pull-right">
    <?php echo DynamicGridviewSize::widget(['dataProvider' => $dataProvider]) ?>
</div>

<div class="clearfix"></div>
<p>
    <a href="#" id="search-form-control">Показать/скрыть форму поиска</a>
</p>
<div class="box box-info" id="fill-search-form" style="display: none;">
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
            <div class="col-md-2">
                <?= $form->field($searchModel, 'category_id')->dropDownList(IncompleteProductSearch::getCategoryList(), ['prompt' => '']) ?>
            </div>
            <div class="col-md-2">
                <?= $form->field($searchModel, 'group_id')->dropDownList(IncompleteProductSearch::getGroupList(), ['prompt' => '']) ?>
            </div>
            <div class="col-md-2">
                <?= $form->field($searchModel, 'status')->dropDownList(ProductHelper::statusList(), ['prompt' => '']) ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-1">
                <?= $form->field($searchModel, 'empty_miniature')->checkbox() ?>
            </div>
            <div class="col-md-1">
                <?= $form->field($searchModel, 'empty_description')->checkbox() ?>
            </div>
            <div class="col-md-1">
                <?= $form->field($searchModel, 'empty_properties')->checkbox() ?>
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
        <?= Html::beginForm(['/product/product/bulk'], 'post', ['class' => 'form form-inline']); ?>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                ['class' => CheckboxColumn::class],
                'id',
                [
                    'attribute' => 'miniature',
                    'format' => 'html',
                    'value' => function (Product $model) {
                        return Html::img($model->getMiniature(), ['style' => 'max-width: 50px;']);
                    }
                ],
                [
                    'attribute' => 'name',
                    'format' => 'html',
                    'value' => function (Product $model) {
                        return Html::a($model->name, UrlNavigatorBackend::viewProduct($model->id));
                    }
                ],
                [
                    'attribute' => 'description',
                    'value' => function (Product $model) {
                        return StringHelper::truncate(strip_tags($model->description), 40);
                    }
                ],
                [
                    'attribute' => 'status',
                    'format' => 'html',
                    'value' => function (Product $model) {
                        return ProductHelper::statusLabel($model->status);
                    }
                ],
            ]
        ]) ?>
        <div class="pull-right">
            <div class="form-group">
                <?= Html::dropDownList(
                    'action',
                    '',
                    [
                        'updateBulk' => 'Редактировать',
                    ],
                    ['class' => 'form-control', 'prompt' => 'Выберите действие']
                ) ?>
            </div>
            <div class="form-group">
                <?= Html::submitButton('Отправить', ['class' => 'btn btn-info']) ?>
            </div>
            <div class="clearfix"></div>
        </div>
        <?= Html::endForm() ?>
    </div>
</div>