<?php

namespace backend\controllers\finance;

use backend\forms\finance\RefundSearch;
use yii\web\Controller;

class RefundController extends Controller
{

    public function actionIndex()
    {
        $searchModel = new RefundSearch();
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

}