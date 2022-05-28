<?php

use backend\helpers\TemplateHelper;
use core\entities\transfer\Transfer;
use core\helpers\finance\TransferHelper;
use yii\helpers\Html;
use yii\widgets\DetailView;

/**
 * @var $this \yii\web\View
 * @var $model Transfer
 */

$this->title = "Перевод #{$model->id}";
$this->params['breadcrumbs'][] = ['label' => 'Переводы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
TemplateHelper::boxWrap($this->params);
?>
<div>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            [
                'attribute' => 'user_id',
                'format' => 'html',
                'value' => function (Transfer $model) {
                    return Html::a($model->user->username, ['user/view', 'id' => $model->user_id]);
                }
            ],
            'description',
            'sum',
            [
                'attribute' => 'type',
                'format' => 'html',
                'value' => function (Transfer $model) {
                    return TransferHelper::typeNameHighlighted($model->type);
                }
            ],
            'date:dateTime',
        ],
    ]) ?>

</div>
