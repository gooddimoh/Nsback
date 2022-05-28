<?php

use core\entities\Product\Property\Property;
use core\entities\Product\Property\PropertyCategory;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\DetailView;

/**
 * @var $model PropertyCategory
 * @var $this View
 */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Свойства', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div>
    <p class="pull-left">
        <?php echo Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-info']) ?>
    </p>
    <div class="pull-right">
        <?php echo Html::a('Внешний ID', ['update-external-id', 'id' => $model->id], ['class' => 'btn btn-info']) ?>
    </div>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            [
                'attribute' => 'category_id',
                'value' => function (Property $model) {
                    return $model->category->name;
                }
            ],
            'name',
            'description'
        ],
    ]) ?>
</div>