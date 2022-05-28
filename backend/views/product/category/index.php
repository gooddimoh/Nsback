<?php

use core\widgets\DynamicGridviewSize;
use frontend\helpers\UrlNavigator;
use rmrevin\yii\fontawesome\FontAwesome;
use yii\helpers\Html;
use core\entities\product\Category;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

/**
 * @var $this \yii\web\View
 * @var $dataProvider \yii\data\ActiveDataProvider
 */

$this->title = 'Категории';
$this->params['breadcrumbs'][] = $this->title;
\backend\helpers\TemplateHelper::boxWrap($this->params);
?>
<div>
    <div class="pull-left">
        <?= Html::a('Новая категория', ['create'], ['class' => 'btn btn-success']) ?>
    </div>
    <div class="pull-right">
        <?php echo DynamicGridviewSize::widget(['dataProvider' => $dataProvider]) ?>
    </div>

    <div class="clearfix"></div>
</div>

<div>
    <?= \himiklab\sortablegrid\SortableGridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'id',
            'name',
            'slug',
            [
                'class' => \yii\grid\ActionColumn::class,
                'template' => '{view} {update} {url}',
                'buttons' => [
                    'url' => function ($url, Category $model) {
                        return Html::a(
                            FontAwesome::icon("chain"),
                            Yii::$app->frontendUrlManager->createUrl(UrlNavigator::viewCategory($model->slug))
                        );
                    }
                ],
            ],
        ],
    ]) ?>
    <small class="text-muted">
        Чтобы изменить порядок: зажмите правую кнопку мыши ячейку с нужной группой и переместите её в желаемое место.
    </small>
</div>
