<?php

namespace frontend\controllers;

use core\readModels\GroupReadRepository;
use frontend\forms\Product\ProductSearch;
use Yii;
use yii\web\Controller;
use yii\web\ErrorAction;

class SiteController extends Controller
{
    private $groups;

    public function __construct(
        $id,
        $module,
        GroupReadRepository $groups,
        $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->groups = $groups;
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => ErrorAction::class,
            ],
        ];
    }

    public function actionIndex()
    {
        $request = Yii::$app->request;

        return $this->render('index', [
            'groups' => $this->groups->getForMainPage($request->get("category_id"), $request->get("group_id")),
            'searchForm' => new ProductSearch(),
            'queryParams' => $request->queryParams,
        ]);
    }

    public function actionMaintenance()
    {
        return $this->render('maintenance');
    }

    public function actionCoinbaseAllowedNetwork()
    {
        return $this->render('coinbase-allowed-network');
    }

}
