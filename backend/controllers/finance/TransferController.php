<?php

namespace backend\controllers\finance;

use backend\forms\finance\TransferSearch;
use core\entities\transfer\Transfer;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class TransferController extends Controller
{
    public function actionIndex()
    {
        $searchModel = new TransferSearch();
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);


        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }


    /***
     * @param $id
     * @return Transfer
     * @throws NotFoundHttpException
     */
    protected function findModel($id)
    {
        if (($model = Transfer::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Перевод не найден');
    }


}