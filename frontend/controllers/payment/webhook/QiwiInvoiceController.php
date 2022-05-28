<?php

namespace frontend\controllers\payment\webhook;

use core\entities\payment\Payment;
use core\services\payment\PaymentService;
use core\payment\qiwiInvoice\QiwiP2P;
use yii\rest\Controller;
use yii\web\HttpException;
use core\settings\storage\QiwiInvoiceSettings;

class QiwiInvoiceController extends Controller
{
    private $settings;
    private $service;

    public function __construct($id, $module, QiwiInvoiceSettings $settings, PaymentService $service, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->settings = $settings;
        $this->service = $service;
    }

    # /payment/webhook/qiwi-invoice/request
    public function actionRequest()
    {
        $headers = \Yii::$app->request->getHeaders();

        $validSignatureFromNotificationServer = $headers->get("X-Api-Signature-SHA256");
        $notificationBody = json_decode(file_get_contents('php://input'), true);
        \Yii::info($notificationBody, "qiwiInvoice");
        $qiwiP2P = new QiwiP2P($this->settings->getPublicKey(), $this->settings->getSecretKey());

        try {
            $qiwiP2P->handleSuccessRubPayment($validSignatureFromNotificationServer, $notificationBody);

            $this->service->paidByReplenish($notificationBody['bill']['customer']['account'],
                $notificationBody['bill']['amount']['value']);

            return ['message' => "Payment successful: " . time()];
        } catch (\Exception $exception) {
            \Yii::$app->errorHandler->logException($exception);
            \Yii::error($exception->getMessage(), "qiwiInvoiceError");
            throw new HttpException(400, $exception->getMessage());
        }
    }

}