<?php

namespace frontend\controllers\payment\webhook;

use core\services\payment\PaymentService;
use core\settings\storage\WebMoneySettings;
use core\payment\webmoney\WebMoneyNameConverter;
use core\payment\webmoney\WebMoneyPayment;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Yii;
use yii\rest\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\HttpException;

class WebMoneyController extends Controller
{
    private $service;
    private $settings;

    public function __construct($id, $module, PaymentService $service, WebMoneySettings $settings, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
        $this->settings = $settings;
    }


    # /payment/webhook/web-money/index
    public function actionIndex()
    {
        throw new ForbiddenHttpException("Out of service");

        if ($this->settings->isDisabled()) {
            throw new ForbiddenHttpException("Module disabled");
        }

        if (Yii::$app->request->post('LMI_PREREQUEST') === "1") {
            return "YES";
        }

        $settings = Yii::$container->get(WebMoneySettings::class);
        $nameConverter = new WebMoneyNameConverter();
        $normalizer = new ObjectNormalizer(null, $nameConverter);
        $serializer = new Serializer(array($normalizer), array(new JsonEncoder()));

        /*** @var $webMoneyPayment WebMoneyPayment */
        $webMoneyPayment = $serializer->deserialize(json_encode(Yii::$app->request->post()), WebMoneyPayment::class, 'json');


        if ($webMoneyPayment->isPaymentSignValid($settings->getRKey())) {
            if (!$webMoneyPayment->hasHold()) {
                $this->service->paidByReplenish($webMoneyPayment->getPaymentDesc(), $webMoneyPayment->getPaymentAmount());
                return 'YES';
            }
            return 'Payment with hold';
        }

        throw new HttpException(400, 'Bad sign');
    }
}