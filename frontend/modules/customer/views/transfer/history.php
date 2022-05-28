<?php

use yii\grid\GridView;
use core\entities\transfer\Transfer;
use core\helpers\finance\TransferHelper;

/* @var $this \yii\web\View */
/* @var $dataProvider \yii\data\ActiveDataProvider */

$this->title = "История переводов";
?>
<div>
    <h3>История переводов</h3>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'id',
            'description',
            [
                'attribute' => 'sum',
                'format' => 'currency',
            ],
            [
                'attribute' => 'type',
                'value' => function (Transfer $model) {
                    return TransferHelper::typeName($model->type);
                }
            ],
            'date:dateTime'
        ]
    ]) ?>
</div>
