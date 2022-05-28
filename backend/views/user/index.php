<?php

use backend\forms\user\UserSearch;
use backend\helpers\TemplateHelper;
use core\entities\user\User;
use rmrevin\yii\fontawesome\FontAwesome;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\web\View;

/**
 * @var $dataProvider ActiveDataProvider
 * @var $this View
 * @var $searchModel UserSearch
 */

$this->title = "Пользователи";
TemplateHelper::boxWrap($this->params);
?>

<div>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'id',
            'username',
            'email',
            'balance:currency',
            'ip',
            [
                'class' => \yii\grid\ActionColumn::class,
                'template' => '{view} {add-balance}',
                'buttons' => [
                    'add-balance' => function ($url, User $model) {
                        return Html::a(FontAwesome::icon("credit-card"), ['user/add-balance', 'id' => $model->id]);
                    }
                ],
            ],
        ]
    ]) ?>
</div>