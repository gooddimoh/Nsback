<?php

namespace console\controllers;

use core\entities\mail\Mail;
use Yii;
use Unisender\ApiWrapper\UnisenderApi;
use yii\console\Controller;

class MailController extends Controller
{
    private UnisenderApi $api;

    public function __construct($id, $module, UnisenderApi $api, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->api = $api;
    }

    public function actionCheck()
    {
        $query = Mail::find()->where(['status' => ['not_sent', 'ok_sent', 'err_will_retry']])
            ->orWhere(['is', 'status', new \yii\db\Expression('null')]);

        /** @var $mail Mail */
        foreach ($query->each() as $mail) {
            try {
                $response = $this->api->checkEmail(['email_id' => $mail->uni_email_id]);
                $result = json_decode($response, true);

                if (isset($result['result']['statuses'][0]['status'])) {
                    $mail->updateStatus($result['result']['statuses'][0]['status']);
                    echo "Success: $mail->status" . PHP_EOL;
                } else {
                    echo "Error: $response" . PHP_EOL;
                }
            } catch (\DomainException $exception) {
                Yii::$app->errorHandler->logException($exception);
                echo $exception->getMessage() . PHP_EOL;
            }
        }
    }

}