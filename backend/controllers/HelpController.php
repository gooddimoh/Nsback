<?php

namespace backend\controllers;

use yii\web\Controller;

class HelpController extends Controller
{

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionOrder()
    {
        return $this->render('order');
    }

    public function actionPayment()
    {
        return $this->render('payment');
    }

    public function actionProduct()
    {
        return $this->render('product');
    }

    public function actionDoNotChangeUrl()
    {
        return $this->render('do-not-change-url');
    }

}