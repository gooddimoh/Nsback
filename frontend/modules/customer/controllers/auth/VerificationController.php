<?php

namespace frontend\modules\customer\controllers\auth;

use core\services\auth\EmailVerificationService;
use Yii;
use yii\web\Controller;

class VerificationController extends Controller
{
    private $service;

    public function __construct($id, $module, EmailVerificationService $service, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
    }

    public function actionRequest()
    {
        $user = Yii::$app->user->identity;

        if (Yii::$app->request->isPost) {
            try {
                $this->service->request($user->getId());
                Yii::$app->session->setFlash('info', 'Письмо отправлено. Пожалуйста, проверяйте папку "СПАМ", если письма нет.');
                return $this->refresh();
            } catch (\DomainException $exception) {
                Yii::$app->errorHandler->logException($exception);
                Yii::$app->session->setFlash('danger', $exception->getMessage());
            }
        }

        return $this->render('request', [
            'user' => $user,
        ]);
    }

    public function actionConfirm($token)
    {
        try {
            $this->service->confirm($token);
            Yii::$app->session->setFlash('info', 'E-mail успешно верифицирован');
        } catch (\DomainException $exception) {
            Yii::$app->errorHandler->logException($exception);
            Yii::$app->session->setFlash('danger', $exception->getMessage());
        }

        return $this->redirect(['request']);
    }


}