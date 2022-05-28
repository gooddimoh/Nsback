<?php

namespace backend\controllers\communication;

use common\rbac\Roles;
use Yii;
use core\entities\communication\Banner;
use core\forms\communication\BannerForm;
use core\services\communication\BannerService;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class BannerController extends Controller
{
    private $service;

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

    public function __construct($id, $module, BannerService $service, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
    }

    public function actionIndex()
    {
        return $this->render('index', [
            'dataProvider' => new ActiveDataProvider([
                'query' => Banner::find(),
                'sort' => ['defaultOrder' => ['id' => SORT_DESC]],
            ])
        ]);
    }

    public function actionCreate()
    {
        $form = new BannerForm();

        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $banner = $this->service->add($form);
                Yii::$app->session->setFlash('info', 'Баннер успешно добавлен');
                return $this->redirect(['view', 'id' => $banner->id]);
            } catch (\DomainException $exception) {
                Yii::$app->errorHandler->logException($exception);
                Yii::$app->session->setFlash('danger', $exception->getMessage());
            }
        }

        return $this->render('create', [
            'model' => $form,
        ]);
    }

    public function actionUpdate($id)
    {
        $banner = $this->findModel($id);
        $form = new BannerForm($banner);

        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->edit($id, $form);
                Yii::$app->session->setFlash('info', 'Баннер успешно отредактирован');
                return $this->redirect(['view', 'id' => $banner->id]);
            } catch (\DomainException $exception) {
                Yii::$app->errorHandler->logException($exception);
                Yii::$app->session->setFlash('danger', $exception->getMessage());
            }
        }

        return $this->render('update', [
            'model' => $form,
            'banner' => $banner,
        ]);
    }

    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        Yii::$app->session->setFlash('info', 'Запись успешно удалена');

        return $this->redirect(['index']);
    }

    /**
     * @param integer $id
     * @return Banner the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Banner::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Баннер не найден');
    }

}