<?php

use core\entities\shop\Shop;
use core\helpers\product\ShopHelper;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model Shop */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Магазины', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\backend\helpers\TemplateHelper::boxWrap($this->params);
?>
    <div>

        <p>
            <?= Html::a('Редактирование', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>

            <?php if ($model->isActive()): ?>
                <?= Html::a("Заблокировать", ['block', 'id' => $model->id], [
                    'class' => 'btn btn-warning',
                    'data' => [
                        'confirm' => 'Вы уверены, что хотите заблокировать магазин? Товары магазина будут доступны для просмотра, но их нельзя будет купить',
                        'method' => 'post',
                    ],

                ]) ?>
            <?php elseif ($model->isBlocked()): ?>
                <?= Html::a("Разблокировать", ['unblock', 'id' => $model->id], [
                    'class' => 'btn btn-success',
                    'data' => [
                        'confirm' => 'Вы уверены, что хотите разблокировать магазин?',
                        'method' => 'post',
                    ],
                ]) ?>
            <?php endif; ?>

            <?= Html::a('Удаление', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Вы уверены, что хотите удалить магазин?',
                    'method' => 'post',
                ],
            ]) ?>

            <?php if ($model->isPlatformLeqshop()): ?>
                <?= Html::a("Настройка провайдера", ['leqshop', 'id' => $model->id], ['class' => 'btn btn-info']) ?>
            <?php endif; ?>
        </p>

        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                'id',
                'name',
                'shop_markup',
                'internal_markup',
                [
                    'attribute' => 'platform',
                    'format' => 'html',
                    'value' => function (Shop $model) {
                        return ShopHelper::platformName($model->platform);
                    }
                ],
                [
                    'attribute' => 'status',
                    'format' => 'html',
                    'value' => function (Shop $model) {
                        return ShopHelper::statusLabel($model->status);
                    }
                ],
            ],
        ]) ?>

    </div>