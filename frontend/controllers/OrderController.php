<?php

namespace frontend\controllers;

use core\readModels\ProductReadRepository;
use core\readModels\OrderHistoryReadRepository;
use core\services\order\OrderHistoryService;
use core\services\order\OrderService;
use core\services\order\ProviderManager;
use Yii;
use core\entities\order\Order;
use frontend\forms\Order\OrderOwnForm;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class OrderController extends Controller
{
    private $historyService;
    private $history;
    private $orderService;
    private $providerManager;
    private $product;

    public function __construct(
        $id,
        $module,
        OrderHistoryService $historyService,
        OrderHistoryReadRepository $history,
        OrderService $orderService,
        ProductReadRepository $product,
        ProviderManager $providerManager,
        $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->historyService = $historyService;
        $this->history = $history;
        $this->orderService = $orderService;
        $this->product = $product;
        $this->providerManager = $providerManager;
    }

    public function actionIndex($ignoreAuth = false)
    {
        if (!Yii::$app->user->isGuest && !$ignoreAuth) {
            return $this->redirect(['/customer/order/history']);
        }

        $form = new OrderOwnForm();
        $dataProvider = null;

        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            if ($form->byIp) {
                $dataProvider = new ActiveDataProvider([
                    'query' => Order::find()->where(['email' => $form->email, 'ip' => Yii::$app->request->userIP]),
                    'sort' => false,
                    'pagination' => false,
                ]);
            } else {
                $this->historyService->create($form);
                Yii::$app->session->setFlash('success', 'Ссылка со списком заказа отправлена вам на email');
            }
        }

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'model' => $form,
        ]);
    }

    public function actionHistory($code)
    {
        $history = $this->history->getByHash($code);

        if (!$history) {
            throw new NotFoundHttpException("История не найдена");
        }

        return $this->render('history', [
            'dataProvider' => new ActiveDataProvider([
                'query' => Order::find()->where(['email' => $history->email]),
                'sort' => ['defaultOrder' => ['id' => SORT_DESC]],
            ]),
            'history' => $history,
        ]);
    }

    public function actionBack($code, $email)
    {
        $order = $this->findModel($code, $email);

        try {
            if ($this->providerManager->buy($order->getId())) {
                return $this->redirect(['result', 'code' => $code, 'email' => $email]);
            }
        } catch (\DomainException $exception) {
            Yii::$app->errorHandler->logException($exception);
            // Do nothing
        }

        return $this->redirect(['view', 'code' => $code, 'email' => $email]);
    }

    public function actionView($code, $email, $goPayment = null)
    {
        $order = $this->findModel($code, $email);

        if ($order->isReadyToDownload()) {
            return $this->redirect(['result', 'code' => $code, 'email' => $email]);
        }

        return $this->render("view", [
            'model' => $order,
            'goPayment' => $goPayment,
        ]);
    }

    public function actionCancel($code, $email)
    {
        $order = $this->findModel($code, $email);

        try {
            $this->orderService->cancelByUser($order->getId());
        } catch (\DomainException $exception) {
            Yii::$app->errorHandler->logException($exception);
            Yii::$app->session->setFlash('danger', $exception->getMessage());
        }

        return $this->redirect(['view', 'code' => $code, 'email' => $email]);
    }

    public function actionResult($code, $email)
    {
        $order = $this->findModel($code, $email);

        if (!$order->isReadyToDownload()) {
            return $this->redirect(['view', 'code' => $code, 'email' => $email]);
        }

        return $this->render('result', [
            'order' => $order,
            'similarProducts' => new ActiveDataProvider([
                'query' => $this->product->getSimilarProducts($order->product->group_id, $order->product->id),
                'pagination' => false,
            ]),
        ]);
    }

    public function actionDownload($code, $email)
    {
        try {
            $order = $this->findModel($code, $email);
            return \Yii::$app->response->sendFile($this->orderService->download($order->getId()));
        } catch (\DomainException $exception) {
            Yii::$app->errorHandler->logException($exception);
            throw new \HttpException($exception->getMessage(), 400);
        }
    }

    /**
     * @param $code
     * @param $email
     * @return Order the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($code, $email)
    {
        if (($model = Order::findOne(['code' => $code, 'email' => $email])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Заказ не найден');
    }

}