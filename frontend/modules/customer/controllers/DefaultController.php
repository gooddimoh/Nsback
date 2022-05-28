<?php

namespace frontend\modules\customer\controllers;

use yii\web\Controller;

/**
 * Default controller for the `customer` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return \yii\web\Response
     */
    public function actionIndex()
    {
        return $this->goHome();
    }
}
