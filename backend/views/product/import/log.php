<?php

use backend\helpers\TemplateHelper;
use backend\helpers\UrlNavigatorBackend;
use yii\helpers\Html;
use core\entities\import\ImportTask;
use core\helpers\product\ImportHelper;

/**
 * @var $model ImportTask
 * @var $this \yii\web\View
 */

$this->title = "Лог импорта #{$model->id}";
TemplateHelper::boxWrap($this->params);
?>

<div>
    <div>
        <ul>
            <li>Магазин: <?= Html::a($model->shop->name, UrlNavigatorBackend::viewShop($model->shop_id)) ?></li>
            <li>Группа: <?= Html::a($model->group->name, UrlNavigatorBackend::viewGroup($model->group_id)) ?></li>
            <li>Статус: <?= ImportHelper::statusName($model->status) ?></li>
            <li>Прогресс: <?= $model->progress ?>%</li>
            <li>Создан: <?= Yii::$app->formatter->asDatetime($model->created_at) ?></li>
        </ul>
    </div>
    <div class="well">
        <?= \yii\helpers\HtmlPurifier::process(nl2br($model->log)) ?>
    </div>
</div>