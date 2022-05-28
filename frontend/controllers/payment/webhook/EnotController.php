<?php

namespace frontend\controllers\payment\webhook;

use core\entities\payment\Payment;
use core\services\payment\PaymentService;
use shop\payment\dto\Replenish;
use core\payment\enot\EnotPaymentHandler;
use core\settings\storage\EnotSettings;
use Yii;
use yii\rest\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\HttpException;

class EnotController extends Controller
{
    private $paymentService;
    private $settings;

    public function __construct(
        $id,
        $module,
        PaymentService $paymentService,
        EnotSettings $settings,
        array $config = []
    )
    {
        $this->paymentService = $paymentService;
        $this->settings = $settings;
        parent::__construct($id, $module, $config);
    }

    # /payment/webhook/enot/index
    public function actionIndex()
    {
        #throw new ForbiddenHttpException("Out of service");

        if ($this->settings->isDisabled()) {
            throw new ForbiddenHttpException("Module disabled");
        }

        $enotHandler = new EnotPaymentHandler(
            $this->settings->getSecondSecret(),
            Yii::$app->request->post()
        );

        if ($enotHandler->signValidation()) {
            try {
                $enotPayment = $enotHandler->getEnotPayment();
                $this->paymentService->paidByReplenish($enotPayment->description, $enotPayment->sum, Payment::METHOD_ENOT);
                return 'YES';
            } catch (\DomainException $exception) {
                Yii::$app->errorHandler->logException($exception);
                throw new HttpException(400, $exception->getMessage());
            }
        }

        throw new ForbiddenHttpException('Bad sign');
    }
}