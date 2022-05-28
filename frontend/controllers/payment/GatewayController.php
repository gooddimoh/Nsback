<?php

namespace frontend\controllers\payment;

use core\payment\BackUrl;
use core\payment\payeer\PayeerPaymentForm;
use core\payment\webmoney\WebMoneyGateway;
use core\readModels\OrderReadRepository;
use core\settings\storage\PayeerSettings;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class GatewayController extends Controller
{
    private $orders;

    public function __construct($id, $module, OrderReadRepository $orders, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->orders = $orders;
    }

    public function actionWebMoney($wallet, $sum, $paymentId, $successUrl = null)
    {
        return $this->render('web-money', [
            'receipt' => new WebMoneyGateway($wallet, $sum, $paymentId, $successUrl)
        ]);
    }

    public function actionPayeer($sum, $paymentId, $backUrl)
    {
        /** @var $settings PayeerSettings */
        $settings = Yii::$container->get(PayeerSettings::class);

        $receipt = new PayeerPaymentForm($settings,
            $paymentId,
            $sum,
            "Оплата счёта {$paymentId}"
        );
        $receipt->setSuccessUrl($backUrl);
        $receipt->setFailUrl($backUrl);

        return $this->render('payeer', [
            'receipt' => $receipt,
        ]);
    }


}