<?php

/**
 * @var $this \yii\web\View
 * @var $dataProvider \yii\data\ActiveDataProvider
 */

use yii\helpers\Html;
use yii\widgets\ListView;

$this->title = "История заказов";
?>
<h3>История заказов</h3>
<p style="text-align: right">
    <?= Html::a("Поиск по e-mail", ['/order/index', 'ignoreAuth' => true]) ?> |
    <?= Html::a("Привязать гостевые заказы", ['order/sync-email']) ?>
</p>
<div style="padding-top: 20px;">
    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'options' => [
            'tag' => 'div',
            'class' => 'purchases',
        ],
        'layout' => "{items}",
        'itemView' => '@frontend/views/_parts/_order-search-item',
    ]);
    ?>
</div>