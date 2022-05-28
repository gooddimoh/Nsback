<?php

use backend\helpers\UrlNavigatorBackend;
use core\entities\import\ImportTask;
use yii\helpers\Html;
use core\helpers\product\ImportHelper;

/**
 * @var $model ImportTask
 */

?>

<div class="box box-default">
    <div class="box-header with-border">
        <h3 class="box-title">
            Процедура импорта #<?= $model->id ?>
        </h3>
        <div class="box-tools pull-right">
            <?= Html::a("<span>[лог]</span>", ['log', 'id' => $model->id]) ?>
            <?= $model->isStopped() ? Html::a("[перезапустить]",
                ['restart', 'id' => $model->id],
                ['data' => ['method' => 'POST', 'confirm' => 'Уверены?']])
                : null ?>
        </div>
    </div>
    <div class="box-body">
        <div class="clearfix"></div>
        <div class="col-xs-6">
            <div class="table-responsive">
                <table class="table">
                    <tbody>
                    <tr>
                        <th style="width:50%">Магазин:</th>
                        <td>
                            <?= Html::a($model->shop->name, UrlNavigatorBackend::viewShop($model->shop_id)) ?>
                        </td>
                    </tr>
                    <tr>
                        <th>Группа:</th>
                        <td>
                            <?= Html::a($model->group->name, UrlNavigatorBackend::viewGroup($model->group_id)) ?>
                        </td>
                    </tr>
                    <tr>
                        <th>Модерировать:</th>
                        <td>
                            <?= Yii::$app->formatter->asBoolean($model->should_moderate) ?>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-xs-6">
            <div class="table-responsive">
                <table class="table">
                    <tbody>
                    <tr>
                        <th>Статус:</th>
                        <td>
                            <?= ImportHelper::statusName($model->status) ?>
                        </td>
                    </tr>
                    <tr>
                        <th>Создан:</th>
                        <td>
                            <?= Yii::$app->formatter->asDatetime($model->created_at) ?>
                        </td>
                    </tr>
                    <tr>
                        <th>Дата завершения:</th>
                        <td>
                            <?= $model->finish_at ? Yii::$app->formatter->asDatetime($model->finish_at) : Yii::$app->formatter->asBoolean(false) ?>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-xs-12">
            <div class="progress">
                <div class="progress-bar progress-bar-<?= $model->isProgressFull() ? "success" : "primary" ?> progress-bar-striped"
                     role="progressbar"
                     aria-valuenow="<?= $model->progress ?>" aria-valuemin="0" aria-valuemax="100"
                     style="width: <?= $model->progress ?>%">
                    <span class="sr-only"><?= $model->progress ?>%</span>
                </div>
            </div>
            <p class="text-center">
                Прогресс:
                <span class="label label-<?= $model->isProgressFull() ? "success" : "primary" ?>">
                    <?= $model->progress ?>%
                </span>
            </p>
        </div>
    </div>
</div>