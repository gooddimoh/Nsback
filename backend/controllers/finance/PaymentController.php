<?php

namespace backend\controllers\finance;

use core\entities\payment\Payment;
use core\services\payment\PaymentService;
use Yii;
use backend\forms\finance\PaymentSearch;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class PaymentController extends Controller
{
    private $service;

    public function __construct($id, $module, PaymentService $service, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
    }
    
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'paid' => ['POST'],
                    'cancel' => ['POST'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $searchModel = new PaymentSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionPaid($id)
    {
        try {
            $this->service->paidManually($id);
            Yii::$app->session->setFlash('info', 'Платеж помечен оплаченным');
        } catch (\DomainException $exception) {
            Yii::$app->errorHandler->logException($exception);
            Yii::$app->session->setFlash('danger', $exception->getMessage());
        }

        return $this->redirect(['view', 'id' => $id]);
    }

    public function actionCancel($id)
    {
        try {
            $this->service->cancel($id);
            Yii::$app->session->setFlash('info', 'Платеж помечен отмененным');
        } catch (\DomainException $exception) {
            Yii::$app->errorHandler->logException($exception);
            Yii::$app->session->setFlash('danger', $exception->getMessage());
        }

        return $this->redirect(['view', 'id' => $id]);
    }

    public function actionView($id)
    {
        return $this->render("view", [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * @param integer $id
     * @return Payment the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Payment::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Платеж не найден');
    }

}