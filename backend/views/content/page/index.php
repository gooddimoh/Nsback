<?php

use core\helpers\PageHelper;
use rmrevin\yii\fontawesome\FontAwesome;
use yii\grid\GridView;
use core\entities\content\Page;
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * @var $dataProvider \yii\data\ActiveDataProvider
 * @var $this \yii\web\View
 */

$this->title = "Страницы";
\backend\helpers\TemplateHelper::boxWrap($this->params);
?>

<p>
    <?= Html::a("Добавить страницу", ['create'], ['class' => 'btn btn-success']) ?>
</p>
<div>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            [
                'attribute' => 'title',
                'format' => 'html',
                'value' => function (Page $model) {
                    return Html::a($model->title, ['update', 'slug' => $model->slug]);
                }
            ],
            [
                'attribute' => 'status',
                'format' => 'html',
                'value' => function (Page $model) {
                    return PageHelper::statusLabel($model->status);
                }
            ],
            [
                'class' => \yii\grid\ActionColumn::class,
                'template' => '{update} {url} {visibility} {delete}',
                'urlCreator' => function ($action, Page $model, $key, $index) {
                    return Url::to([$action, 'slug' => $model->slug]);
                },
                'buttons' => [
                    'url' => function ($url, Page $model) {
                        return Html::a(
                            FontAwesome::icon("link"),
                            Yii::$app->frontendUrlManager->createUrl(['/page/view', 'slug' => $model->slug]),
                            ['target' => '_blank']
                        );
                    },
                    'visibility' => function ($url, Page $model) {
                        if ($model->isPublic()) {
                            $data = ['icon' => 'eye-slash', 'action' => 'draft', 'message' => 'Вы уверены, что хотите поместить в черновик? Страница станет недоступна для пользователей'];
                        } elseif ($model->isDraft()) {
                            $data = ['icon' => 'bullhorn', 'action' => 'public', 'message' => 'Вы уверены, что хотите опубликовать страницу? Она станет доступна для пользователей'];
                        } else {
                            return null;
                        }

                        return Html::a(FontAwesome::icon($data['icon']), [$data['action'], 'slug' => $model->slug], [
                            'data' => [
                                'method' => 'POST',
                                'confirm' => $data['message'],
                            ]
                        ]);
                    }
                ],
            ],
        ]
    ]) ?>
</div>