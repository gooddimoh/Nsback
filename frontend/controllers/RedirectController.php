<?php

namespace frontend\controllers;

use core\entities\order\Order;
use core\entities\order\OrderHistory;
use yii\web\Controller;

class RedirectController extends Controller
{
    public function actionTo()
    {
        $url = \Yii::$app->request->url;
        return $this->renderContent("Page: $url");
    }

}