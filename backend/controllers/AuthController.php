<?php

namespace backend\controllers;

use core\forms\auth\TwoFactorForm;
use core\services\auth\AuthService;
use core\services\auth\verify\VerificationAuthService;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use core\forms\auth\LoginForm;

class AuthController extends Controller
{
    public $layout = 'main-login.php';

    private $auth;
    private $verifyAuth;

    public function __construct($id, $module, AuthService $auth, VerificationAuthService $verifyAuth, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->auth = $auth;
        $this->verifyAuth = $verifyAuth;
    }

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'verification-resend' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * @return mixed
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $form = new LoginForm();

        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $user = $this->auth->authAsAdmin($form);
                $verifyAuth = $this->verifyAuth->add($user->getId(), $user->getVerificationContact(), Yii::$app->request->userIP);
                return $this->redirect(['verification', 'hash' => $verifyAuth->hash]);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }

        return $this->render('login', [
            'model' => $form,
        ]);
    }

    public function actionVerification($hash)
    {
        $form = new TwoFactorForm();

        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $user = $this->verifyAuth->verify($hash, $form->verifyCode);
                Yii::$app->user->login($user, $form->rememberMe ? Yii::$app->params['user.rememberMeDuration'] : 0);
                return $this->redirect(['/site/index']);
            } catch (\DomainException $exception) {
                Yii::$app->errorHandler->logException($exception);
                Yii::$app->session->setFlash('danger', $exception->getMessage());
            }
        }

        return $this->render('verification', [
            'model' => $form,
            'hash' => $hash,
        ]);
    }

    public function actionVerificationResend($hash)
    {
        try {
            $this->verifyAuth->resend($hash);
            Yii::$app->session->setFlash('info', 'Код успешно отправлен');
        } catch (\DomainException $exception) {
            Yii::$app->errorHandler->logException($exception);
            Yii::$app->session->setFlash('danger', $exception->getMessage());
        }

        return $this->redirect(['verification', 'hash' => $hash]);
    }

    /**
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
}
