<?php

namespace frontend\controllers;

use core\entities\content\Page;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class PageController extends Controller
{
    public function actionView($slug)
    {
        return $this->render('view', [
            'page' => $this->findModel($slug),
        ]);
    }

    public function actionFaq()
    {
        return $this->render('faq');
    }

    public function actionAgreement()
    {
        return $this->redirect(['view', 'slug' => 'rules']);
    }

    /**
     * @param string $slug
     * @return Page the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($slug)
    {
        if (($model = Page::findOne(['slug' => $slug, 'status' => Page::STATUS_PUBLIC])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Страница не найдена');
    }

}