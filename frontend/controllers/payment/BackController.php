<?php

namespace frontend\controllers\payment;

use core\entities\payment\Payment;
use core\payment\BackUrl;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;

class BackController extends Controller
{

    public function actionFreekassa()
    {
        $request = \Yii::$app->request;
        $paymentId = $request->get("MERCHANT_ORDER_ID");
        $email = $request->get("email");

        if (!$paymentId) {
            throw new ForbiddenHttpException("Не передан Payment ID");
        }

        if ($email) {
            $payment = $this->findModel($paymentId);

            if ($payment->paymentOrder->order->email !== $email) {
                throw new ForbiddenHttpException("Веденный e-mail $email не связан с платежом");
            }
            if (!$payment->isMethodFreekassa()) {
                throw new ForbiddenHttpException("Платеж #{$paymentId} не связан с FreeKassa");
            }

            return $this->redirect(BackUrl::createForOrder($payment->paymentOrder->order));
        }


        return $this->render('freekassa', [
            'paymentId' => $paymentId,
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