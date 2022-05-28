<?php

namespace frontend\modules\customer\controllers;

use core\readModels\TransferReadRepository;
use yii\data\ActiveDataProvider;
use yii\web\Controller;

class TransferController extends Controller
{
    public $defaultAction = "history";
    private $transfer;

    public function __construct($id, $module, TransferReadRepository $transfer, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->transfer = $transfer;
    }

    public function actionHistory()
    {
        return $this->render('history', [
            'dataProvider' => new ActiveDataProvider([
                'query' => $this->transfer->getOwn(\Yii::$app->user->id),
                'sort' => ['defaultOrder' => ['id' => SORT_DESC]],
            ]),
        ]);
    }

}