<?php

use yii\widgets\ListView;
use yii\web\View;
use yii\helpers\Html;

/**
 * @var $dataProvider \yii\data\ActiveDataProvider
 * @var $this View
 */

$this->title = 'Импорт';
\backend\helpers\TemplateHelper::boxWrap($this->params);
?>
<p>
    <?= Html::a("Новая процедура", ['create'], ['class' => 'btn btn-success']) ?>
</p>
<div>
    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'options' => [
            'tag' => 'div',
            'class' => 'list-wrapper',
            'id' => 'list-wrapper',
        ],
        'layout' => "{summary}\n{items}\n{pager}",
        'itemView' => '_import-item',
    ]);
    ?>
</div>