<?php

namespace frontend\modules\customer\controllers;

use core\services\order\AssignGuestOrderService;
use Yii;
use core\readModels\OrderReadRepository;
use core\services\auth\EmailVerificationService;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;

class OrderController extends Controller
{
    public $defaultAction = "history";

    private $orders;
    private $assignGuestOrder;

    public function __construct($id, $module, OrderReadRepository $orders, AssignGuestOrderService $assignGuestOrder, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->orders = $orders;
        $this->assignGuestOrder = $assignGuestOrder;
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

    public function actionHistory()
    {
        return $this->render('history', [
            'dataProvider' => new ActiveDataProvider([
                'query' => $this->orders->getOwn(\Yii::$app->user->id),
                'sort' => ['defaultOrder' => ['id' => SORT_DESC]],
            ]),
        ]);
    }

    public function actionSyncEmail()
    {
        $user = Yii::$app->user->identity;

        if (Yii::$app->request->isPost) {
            try {
                $assignedCounter = $this->assignGuestOrder->assignAll($user->getId());
                $message = $assignedCounter > 0 ? "Успешно привязано заказов: $assignedCounter" : "Нет заказов к привязке";
                Yii::$app->session->setFlash('info', $message);
            } catch (\DomainException $exception) {
                Yii::$app->errorHandler->logException($exception);
                Yii::$app->session->setFlash('danger', $exception->getMessage());
            }
        }

        return $this->render("sync-email", [
            'user' => $user,
        ]);
    }


}