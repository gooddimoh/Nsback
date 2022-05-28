<?php

use core\entities\Product\Property\PropertyCategory;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\DetailView;

/**
 * @var $model PropertyCategory
 * @var $this View
 */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Категории свойств', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div>
    <p class="pull-left">
        <?php echo Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-info']) ?>
    </p>
    <p class="pull-right">
        <?php echo Html::a('Внешний ID', ['update-external-id', 'id' => $model->id], ['class' => 'btn btn-info']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'description'
        ],
    ]) ?>
</div>