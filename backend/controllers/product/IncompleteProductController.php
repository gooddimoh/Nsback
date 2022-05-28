<?php

namespace backend\controllers\product;

use common\rbac\Roles;
use Yii;
use backend\forms\product\IncompleteProductSearch;
use yii\filters\AccessControl;
use yii\web\Controller;

class IncompleteProductController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => [Roles::ROLE_ADMINISTRATOR, Roles::ROLE_SENIOR_MANAGER],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $searchModel = new IncompleteProductSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }




}