<?php

use backend\forms\Finance\TransferSearch;
use core\entities\transfer\Transfer;
use core\helpers\finance\TransferHelper;
use yii\grid\GridView;
use yii\helpers\Html;

/**
 * @var $dataProvider \yii\data\ActiveDataProvider
 * @var $this \yii\web\View
 * @var $searchModel TransferSearch
 */

$this->title = "Переводы";
\backend\helpers\TemplateHelper::boxWrap($this->params);
?>

<div>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'id',
            [
                'attribute' => 'user_id',
                'format' => 'html',
                'value' => function (Transfer $model) {
                    return Html::a($model->user->username, ['user/view', 'id' => $model->user_id]);
                },
                'filterInputOptions' => ['placeholder' => 'Введите ID пользователя', 'class' => 'form-control'],
            ],
            'description',
            'sum:currency',
            [
                'attribute' => 'type',
                'format' => 'html',
                'value' => function (Transfer $model) {
                    return TransferHelper::typeNameHighlighted($model->type);
                },
                'filter' => TransferHelper::typeList(),
            ],
            'date:dateTime',
            [
                'class' => \yii\grid\ActionColumn::class,
                'template' => '{view}',
            ],
        ]
    ]) ?>
</div>