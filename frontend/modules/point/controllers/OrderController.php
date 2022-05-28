<?php

namespace frontend\modules\point\controllers;

use core\entities\product\Product;
use core\services\order\ProviderManager;
use Yii;
use core\entities\order\Order;
use core\forms\order\OrderForm;
use core\services\order\BuyService;
use core\services\order\CheckReadinessService;
use yii\rest\Controller;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;

class OrderController extends Controller
{
    private $buyService;
    private $checkService;
    private $providerManager;

    public function __construct(
        $id,
        $module,
        BuyService $buyService,
        CheckReadinessService $checkService,
        ProviderManager $providerManager,
        $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->buyService = $buyService;
        $this->checkService = $checkService;
        $this->providerManager = $providerManager;
    }

    public function actionCheck()
    {
        $form = new OrderForm();
        $form->load(Yii::$app->request->post(), "");
        $id = Yii::$app->request->post('product_id');

        $result = $this->checkService->check($form->quantity, $id);

        if (!$result['success']) {
            Yii::info(array_merge($result, ['order' => $form->getAttributes(), 'id' => $id]), "checkReadiness");
        }

        return $result;
    }

    public function actionBuy()
    {
        $request = Yii::$app->request;

        $id = $request->post('product_id');
        $ip = $request->userIP;
        $userId = !Yii::$app->user->isGuest ? Yii::$app->user->id : null;

        $product = $this->findService($id);

        $form = new OrderForm();

        if ($form->load(Yii::$app->request->post(), '') && $form->validate()) {
            try {
                $paymentData = $this->buyService->buy($form, $product->id, $ip, $userId);
                return ['payment_link' => $paymentData->paymentLink];
            } catch (\DomainException $exception) {
                Yii::$app->errorHandler->logException($exception);
                throw new HttpException(400, $exception->getMessage());
            }
        }

        return $form;
    }


    public function actionCheckReady($id)
    {
        $order = $this->findOrder($id);

        switch ($order->status) {
            case Order::STATUS_UNPAID:
            {
                $needRefreshPage = false;
                break;
            }
            case Order::STATUS_PENDING:
            {
                $needRefreshPage = $this->providerManager->buy($id);
                break;
            }
            case Order::STATUS_CANCELED:
            case Order::STATUS_COMPLETED:
            case Order::STATUS_ERROR:
            case Order::STATUS_REFUND:
            case Order::STATUS_SUSPENDED:
                $needRefreshPage = true;
                break;
            default:
            {
                throw new \DomainException("Статус не может быть обработан. Пожалуйста, сообщите об этом поддержке");
            }
        }


        return [
            'need_refresh' => $needRefreshPage,
        ];
    }

    /**
     * @param integer $id
     * @return Order the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findOrder($id)
    {
        if (($model = Order::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Товар не найден. Пожалуйста, попробуйте еще раз или обратитесь в поддержку');
    }

    /**
     * @param integer $id
     * @return Product the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findService($id)
    {
        if (($model = Product::findOne(['id' => $id, 'status' => Product::STATUS_ACTIVE])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Товар не найден');
    }

}