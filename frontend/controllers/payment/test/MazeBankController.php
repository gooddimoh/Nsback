<?php

namespace frontend\controllers\payment\test;

use core\entities\payment\Payment;
use core\services\payment\PaymentService;
use core\settings\storage\MazeBankSettings;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;

class MazeBankController extends Controller
{
    private $paymentService;

    public function init()
    {
        parent::init();
        if (!YII_ENV_DEV) {
            throw new ForbiddenHttpException("Available only in DEV Environment");
        }
    }

    public function __construct($id, $module, PaymentService $paymentService, MazeBankSettings $settings, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->paymentService = $paymentService;

        if ($settings->isDisabled()) {
            throw new ForbiddenHttpException("Disabled");
        }
    }

    public function actionPayment($id, $backUrl = null)
    {

        return $this->render('payment', [
            'payment' => Payment::findOne($id),
            'backUrl' => $backUrl,
        ]);
    }

    public function actionCompleted($id, $backUrl)
    {
        $request = \Yii::$app->request;
        $payment = $this->findModel($id);

        $this->paymentService->paidByReplenish($payment->id, $payment->sum);

        return $this->redirect($backUrl);
    }

    /**
     * @param integer $id
     * @return \core\entities\payment\Payment the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Payment::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Payment not found');
    }

}