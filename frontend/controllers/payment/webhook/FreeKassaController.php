<?php

namespace frontend\controllers\payment\webhook;

use core\payment\freekassa\FreekassaPaymentHandler;
use core\services\payment\PaymentService;
use core\settings\storage\FreekassaSettings;
use Yii;
use yii\filters\AccessControl;
use yii\rest\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\HttpException;

class FreeKassaController extends Controller
{
    private $paymentService;
    private $settings;

    public function __construct($id, $module, PaymentService $paymentService, FreekassaSettings $settings, array $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->paymentService = $paymentService;
        $this->settings = $settings;
    }

    # /payment/webhook/free-kassa/index
    public function actionIndex()
    {
        $request = Yii::$app->request;

        if ($this->settings->isDisabled()) {
            throw new ForbiddenHttpException("Module disabled");
        }

        $freekassaHandler = new FreekassaPaymentHandler($this->settings->getSecondKey(), $request->post());

        if (!$freekassaHandler->isIpAllowed($request->userIP)) {
            throw new ForbiddenHttpException("Not allowed IP");
        }
        if ($freekassaHandler->signValidation()) {
            try {
                $freekassaPayment = $freekassaHandler->getFreekassaPayment();
                $this->paymentService->paidByReplenish($freekassaPayment->description, $freekassaPayment->sum);
                return 'YES';
            } catch (\DomainException $exception) {
                Yii::$app->errorHandler->logException($exception);
                throw new HttpException(400, $exception->getMessage());
            }
        }

        throw new ForbiddenHttpException('Bad sign');
    }
}