<?php

namespace frontend\controllers\payment\webhook;

use core\payment\lava\CallbackInvoice;
use core\payment\lava\CallbackTypes;
use core\payment\lava\LavaClient;
use core\services\payment\PaymentService;
use Yii;
use yii\rest\Controller;

class LavaController extends Controller
{
    private $service;
    private $client;

    public function __construct($id, $module, PaymentService $service, LavaClient $client, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
        $this->client = $client;
    }

    // /payment/webhook/lava/callback
    public function actionCallback()
    {
        $data = json_decode(file_get_contents('php://input'), true);

        if (!isset($data['type'])) {
            Yii::info('Type missed');
            return ['message' => 'Type missed'];
        }
        if ($data['type'] != CallbackTypes::TYPE_INVOICE) {
            Yii::info('Unhandled callback type');
            return ['message' => 'Unhandled callback type'];
        }

        $callback = new CallbackInvoice($data);

        if ($callback->isStatusSuccess()) {
            $invoice = $this->client->infoInvoice($callback->getInvoiceId(), $callback->getOrderId());
            $this->service->paidByReplenish($invoice->getOrderId(), $invoice->getSum());
            return ['message' => 'Success'];
        }

        Yii::info('Unhandled status');
        return ['message' => 'Unhandled status'];
    }

}