<?php

use core\entities\order\PromoCode;
use yii\helpers\Html;
use yii\grid\GridView;
use core\helpers\order\PromoCodeHelper;
use backend\forms\finance\PromoCodeSearch;

/**
 * $this yii\web\View
 * @var $dataProvider yii\data\ActiveDataProvider
 * @var $searchModel PromoCodeSearch
 */

$this->title = 'Промо-коды';
$this->params['breadcrumbs'][] = $this->title;
$script = <<<JS
function showPromoCode(context, code) {
  $(context).text(code);
}
JS;
$this->registerJs($script, \yii\web\View::POS_END);
\backend\helpers\TemplateHelper::boxWrap($this->params);

?>
<div class="promo-code-list">

    <p>
        <?= Html::a('Новый промо-код', ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Массовое добавление', ['bulk-create'], ['class' => 'btn btn-info']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'id',
            [
                'attribute' => 'code',
                'format' => 'raw',
                'value' => function (PromoCode $model) {
                    $code = Html::encode($model->code);
                    return Html::tag('span', PromoCodeHelper::hideParts($code), [
                        'onclick' => "showPromoCode(this, '$code')",
                    ]);
                }
            ],
            'comment',
            'activation_limit',
            [
                'attribute' => 'activation_count',
                'value' => function (PromoCode $model) {
                    return count($model->promoCodeActivations);
                },
                'label' => 'Количество активаций',
            ],
            [
                'attribute' => 'percent',
                'value' => function (PromoCode $model) {
                    return "{$model->percent}%";
                }
            ],
            [
                'attribute' => 'status',
                'format' => 'raw',
                'value' => function (PromoCode $model) {
                    return PromoCodeHelper::statusName($model->status);
                },
                'filter' => PromoCodeHelper::statusList(),
            ],
            'date:date',
            [
                'class' => \yii\grid\ActionColumn::class,
                'template' => '{view} {delete}',
            ],
        ],
    ]); ?>
</div>
