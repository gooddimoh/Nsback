<?php

use core\entities\communication\Banner;
use core\helpers\communication\BannerHelper;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model Banner */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Баннеры', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div>

    <p>
        <?= Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы уверены, что хотите удалить баннер? Если его нужно временно скрыть - воспользуйтесь настройками',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            [
                'attribute' => 'content',
                'format' => 'html',
                'value' => function (Banner $model) {
                    return Html::a(Html::img($model->image_url), $model->target_url);
                }
            ],
            [
                'attribute' => 'location',
                'value' => function (Banner $model) {
                    return BannerHelper::locationName($model->location);
                }
            ],
            [
                'attribute' => 'is_active',
                'format' => 'html',
                'value' => function (Banner $model) {
                    return BannerHelper::activationLabel($model->is_active);
                }
            ],
        ],
    ]) ?>

</div>
