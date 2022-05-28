<?php

use core\entities\order\PromoCodeActivation;
use yii\helpers\Html;
use yii\widgets\DetailView;
use core\helpers\order\PromoCodeHelper;
use core\entities\order\PromoCode;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model PromoCode */
/* @var $activations \yii\data\ActiveDataProvider */

$this->title = "Редактирование промо-кода: " . PromoCodeHelper::hideParts($model->code) . "[{$model->id}]";
$this->params['breadcrumbs'][] = ['label' => 'Промо-коды', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$script = <<<JS
function showPromoCode(context, code) {
  $(context).text(code);
}
JS;
$this->registerJs($script, \yii\web\View::POS_END);
?>

<p>
    <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
        'class' => 'btn btn-danger',
        'data' => [
            'confirm' => 'Вы уверены, что хотите удалить данную запись?',
            'method' => 'post',
        ],
    ]) ?>
    <?php if($model->isActive()): ?>
        <?= Html::a('Деактивировать', ['inactivate', 'id' => $model->id], [
            'class' => 'btn btn-warning',
            'data' => [
                'confirm' => 'Вы уверены, что хотите деактивировать промо-код?',
                'method' => 'post',
            ],
        ]) ?>
    <?php elseif($model->isInactive()): ?>
        <?= Html::a('Активировать', ['activate', 'id' => $model->id], [
            'class' => 'btn btn-success',
            'data' => [
                'confirm' => 'Вы уверены, что хотите активировать данный промо-код?',
                'method' => 'post',
            ],
        ]) ?>
    <?php endif; ?>
</p>

<div class="box box-info">
    <div class="box-header">
        <div class="box-title">Детали</div>
    </div>
    <div class="box-body">
        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
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
                'percent',
                [
                    'attribute' => 'status',
                    'format' => 'raw',
                    'value' => function (PromoCode $model) {
                        return PromoCodeHelper::statusName($model->status);
                    },
                    'filter' => PromoCodeHelper::statusList(),
                ],
                'date:dateTime',
            ],
        ]) ?>
    </div>
</div>

<div class="box box-success">
    <div class="box-header">
        <div class="box-title">
            Активации
        </div>
        <div class="box-body">
            <?= GridView::widget([
                'dataProvider' => $activations,
                'columns' => [
                    [
                        'attribute' => 'payment_id',
                        'format' => 'html',
                        'value' => function (PromoCodeActivation $model) {
                            return Html::a("#{$model->payment_id}", ['finance/payment/view', 'id' => $model->payment_id]);
                        }
                    ],
                    [
                        'attribute' => 'percent',
                        'value' => function (PromoCodeActivation $model) {
                            return "{$model->percent}%";
                        }
                    ],
                    'discount_amount',
                    'date:dateTime',
                ]
            ]) ?>
        </div>
    </div>
</div>
