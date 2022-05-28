<?php

namespace frontend\modules\customer\controllers;

use core\entities\payment\Payment;
use core\forms\deposit\DepositForm;
use core\services\deposit\DepositService;
use DomainException;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\Controller;

class DepositController extends Controller
{
    private $service;

    public function __construct($id, $module, DepositService $service, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
    }

    public function actionIndex()
    {
        $form = new DepositForm();

        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                return $this->redirect($this->service->create($form, Yii::$app->user->id));
            } catch (DomainException $exception) {
                Yii::$app->errorHandler->logException($exception);
                Yii::$app->session->setFlash('danger', $exception->getMessage());
            }
        }

        return $this->render('index', [
            'model' => $form,
            'history' => new ActiveDataProvider([
                'query' => Payment::findDepositOnly(),
                'sort' => ['defaultOrder' => ['id' => SORT_DESC]],
            ])
        ]);
    }


}