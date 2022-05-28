<?php

namespace frontend\controllers\payment\webhook;

use core\payment\payeer\PayeerHandler;
use core\services\payment\PaymentService;
use core\settings\storage\PayeerSettings;
use Yii;
use yii\web\Controller;

class PayeerController extends Controller
{
    private $settings;
    private $service;

    public $enableCsrfValidation = false;

    public function __construct($id, $module, PayeerSettings $settings, PaymentService $service, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->settings = $settings;
        $this->service = $service;
    }

    // /payment/webhook/payeer/callback
    public function actionCallback()
    {
        $request = Yii::$app->request;
        $data = $request->post();
        $handle = new PayeerHandler($data, $request->userIP, $this->settings->getSecret());
        $handle->check();

        try {
            $this->service->paidByReplenish($data['m_orderid'], $data['m_amount']);
            return "{$data['m_orderid']}|success";
        } catch (\DomainException $exception) {
            Yii::$app->errorHandler->logException($exception);
            throw new \HttpException(400, $exception->getMessage());
        }
    }

}