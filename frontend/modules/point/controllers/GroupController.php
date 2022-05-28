<?php

namespace frontend\modules\point\controllers;

use core\readModels\GroupReadRepository;
use yii\rest\Controller;
use yii\web\Response;

class GroupController extends Controller
{
    private $groups;

    public function __construct($id, $module, GroupReadRepository $groups, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->groups = $groups;
    }

    public function actionListByCategory()
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;

        return $this->groups->getByCategory(\Yii::$app->request->get("category"))->all();

    }

}