<?php

namespace frontend\controllers\payment\webhook;

use core\payment\coinbase\CoinbaseHandler;
use core\services\payment\PaymentService;
use core\settings\storage\CoinbaseSettings;
use Yii;
use CoinbaseCommerce\Exceptions\SignatureVerificationException;
use yii\rest\Controller;
use yii\web\ForbiddenHttpException;

class CoinbaseController extends Controller
{
    private $service;
    private $settings;

    public function __construct($id, $module, PaymentService $service, CoinbaseSettings $settings, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
        $this->settings = $settings;
    }

    # /payment/webhook/coinbase/index
    public function actionIndex()
    {
        if ($this->settings->isDisabled()) {
            throw new ForbiddenHttpException("Module disabled");
        }

        $data = file_get_contents('php://input');
        $headers = Yii::$app->request->getHeaders();
        try {
            $event = CoinbaseHandler::buildEvent($data, $headers->get('X-CC-Webhook-Signature'), $this->settings->getWebHookKey());
            Yii::debug(json_encode($event), 'coinbase');

            if ($event->type !== "charge:confirmed") {
                Yii::debug('info', 'Event has not type confirmed');
                return ['status' => 'not confirmed status'];
            }

            $this->service->paidByReplenish($event['data']['metadata']['pay_id'], $event['data']['pricing']['local']['amount']);

            return ['status' => 'ok',];
        } catch (SignatureVerificationException $exception) {
            throw new ForbiddenHttpException('Bad signature');
        }
    }
}