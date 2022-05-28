<?php

namespace backend\controllers;

use core\entities\product\Product;
use core\entities\order\Order;
use Yii;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\ErrorAction;

/**
 * Site controller
 */
class SiteController extends Controller
{


    public function actions()
    {
        return [
            'error' => [
                'class' => ErrorAction::class,
                'view' => !Yii::$app->user->isGuest ? '@backend/views/site/error.php' :
                    '@backend/views/site/error-guest.php',
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->render('index', [
            'latestOrderDataProvider' => new ActiveDataProvider([
                'query' => Order::findConsiderRole()->orderBy(['id' => SORT_DESC]),
                'sort' => false,
                'pagination' => ['pageSize' => 7],
            ]),
            'recentlyProductDataProvider' => new ActiveDataProvider([
                'query' => Product::find()->where(['status' => Product::STATUS_ACTIVE])->orderBy(['id' => SORT_DESC]),
                'sort' => false,
                'pagination' => ['pageSize' => 4],
            ]),
        ]);
    }

}
