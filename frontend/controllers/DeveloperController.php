<?php

namespace frontend\controllers;

use yii\web\Controller;

class DeveloperController extends Controller
{

    public function actionIndex()
    {
        return $this->render('index');
    }

}