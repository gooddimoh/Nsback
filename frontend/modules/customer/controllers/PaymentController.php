<?php

namespace frontend\modules\customer\controllers;

use core\payment\BackUrl;
use core\services\user\BalancePurchaseService;
use Yii;
use core\entities\order\Order;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;

class PaymentController extends Controller
{
    private $balancePayment;

    public function __construct($id, $module, BalancePurchaseService $balancePayment, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->balancePayment = $balancePayment;
    }

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionConfirm($payment, $code, $email)
    {
        $order = $this->findOrder($code, $email);

        if (\Yii::$app->request->isPost) {
            try {
                $this->balancePayment->paid($payment, Yii::$app->user->id);
                return $this->redirect(BackUrl::createForOrder($order));
            } catch (\DomainException $exception) {
                Yii::$app->errorHandler->logException($exception);
                throw new HttpException(400, $exception->getMessage());
            }
        }

        return $this->render('confirm', [
            'order' => $order,
        ]);
    }

    public function actionInvalidType()
    {
        throw new ForbiddenHttpException("Данный платеж не предназначен для пополнения");
    }

    /**
     * @param string $code
     * @param string $email
     * @return Order the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findOrder(string $code, string $email)
    {
        if (($model = Order::findOne(['code' => $code, 'email' => $email])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Заказ не найден');
    }

}