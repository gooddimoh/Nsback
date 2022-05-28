<?php

use backend\forms\product\GroupSearch;
use frontend\helpers\UrlNavigator;
use rmrevin\yii\fontawesome\FontAwesome;
use yii\helpers\Html;
use core\entities\product\Group;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

/**
 * @var $this \yii\web\View
 * @var $dataProvider \yii\data\ActiveDataProvider
 * @var $searchModel GroupSearch
 */

$this->title = 'Группы';
$this->params['breadcrumbs'][] = $this->title;
\backend\helpers\TemplateHelper::boxWrap($this->params);
?>
<div>
    <div class="pull-left">
        <?= Html::a('Новая группа', ['create'], ['class' => 'btn btn-success']) ?>
    </div>
    <div class="pull-right">
        <?php echo \core\widgets\DynamicGridviewSize::widget(['dataProvider' => $dataProvider]) ?>
    </div>

    <div class="clearfix"></div>
</div>

<div style="padding-top: 10px;">
    <?= \himiklab\sortablegrid\SortableGridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'id',
            [
                'attribute' => 'category_id',
                'format' => 'html',
                'value' => function (Group $group) {
                    return $group->category->name;
                },
                'filter' => GroupSearch::getCategoryList(),
            ],
            'name',
            [
                'class' => \yii\grid\ActionColumn::class,
                'template' => '{view} {update} {url}',
                'buttons' => [
                    'url' => function ($url, Group $model) {
                        return Html::a(
                            FontAwesome::icon("chain"),
                            Yii::$app->frontendUrlManager->createUrl(UrlNavigator::viewGroup($model->slug))
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
