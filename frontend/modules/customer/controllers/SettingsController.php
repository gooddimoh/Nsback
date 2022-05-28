<?php

namespace frontend\modules\customer\controllers;

use core\services\user\UserService;
use Yii;
use core\forms\user\ChangeMyPasswordForm;
use yii\web\Controller;

class SettingsController extends Controller
{
    public $defaultAction = "change-password";

    private $service;

    public function __construct($id, $module, UserService $service, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
    }

    public function actionChangePassword()
    {
        $form = new ChangeMyPasswordForm(Yii::$app->user->identity->password_hash);

        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->changePassword(Yii::$app->user->id, $form);
                Yii::$app->session->setFlash('success', 'Пароль успешно изменен');
                return $this->refresh();
            } catch (\DomainException $exception) {
                Yii::$app->errorHandler->logException($exception);
                Yii::$app->session->setFlash('danger', $exception->getMessage());
            }
        }

        return $this->render('change-password', [
            'model' => $form,
        ]);
    }

    public function actionApi()
    {
        if (Yii::$app->request->isPost) {
            try {
                $this->service->changeApiKey(Yii::$app->user->id);
                Yii::$app->session->setFlash('success', 'Ключ API изменен');
                return $this->refresh();
            } catch (\DomainException $exception) {
                Yii::$app->errorHandler->logException($exception);
                Yii::$app->session->setFlash('danger', $exception->getMessage());
            }
        }

        return $this->render('api');
    }

}