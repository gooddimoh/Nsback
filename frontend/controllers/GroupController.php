<?php

namespace frontend\controllers;

use core\entities\product\Product;
use core\entities\product\Group;
use frontend\forms\Product\ProductSearch;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class GroupController extends Controller
{

    public function actionView($slug)
    {
        $group = $this->findModel($slug);
        return $this->render('view', [
            'group' => $group,
            'searchForm' => new ProductSearch(),
            'queryParams' => \Yii::$app->request->queryParams,
        ]);
    }

    /**
     * @param string $slug
     * @return Group the loaded model
     * @throws \yii\web\NotFoundHttpException if the model cannot be found
     */
    protected function findModel($slug)
    {
        if (($model = Group::findOne(['slug' => $slug])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Группа не найдена');
    }

}