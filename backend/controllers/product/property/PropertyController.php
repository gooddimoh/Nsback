<?php

namespace backend\controllers\product\property;

use core\entities\product\property\Property;
use core\forms\product\property\PropertyExternalIdForm;
use core\forms\product\property\PropertyForm;
use core\services\product\property\PropertyService;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class PropertyController extends Controller
{
    private $service;

    public function __construct($id, $module, PropertyService $service, array $config = [])
    {
        $this->service = $service;
        parent::__construct($id, $module, $config);
    }

    public function behaviors(): array
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Property::find(),
            'sort' => ['defaultOrder' => ['id' => SORT_DESC]]
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionCreate()
    {
        $form = new PropertyForm();

        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $group = $this->service->add($form);
                Yii::$app->session->setFlash('info', 'Свойство успешно создано!');
                return $this->redirect(['view', 'id' => $group->id]);
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
        $property = $this->findModel($id);
        $form = new PropertyForm($property);

        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->edit($id, $form);
                Yii::$app->session->setFlash('success', 'Успешно изменено');
                return $this->redirect(['view', 'id' => $property->id]);
            } catch (\DomainException $exception) {
                Yii::$app->errorHandler->logException($exception);
                Yii::$app->session->setFlash('danger', $exception->getMessage());
            }
        }

        return $this->render('update', [
            'model' => $form,
            'property' => $property,
        ]);
    }

    public function actionUpdateExternalId($id)
    {
        $property = $this->findModel($id);
        $form = new PropertyExternalIdForm($property->external_id);

        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->editExternalId($id, $form);
                Yii::$app->session->setFlash('info', 'Внешний ID успешно обновлен');
                return $this->refresh();
            } catch (\DomainException $exception) {
                Yii::$app->errorHandler->logException($exception);
                Yii::$app->session->setFlash('danger', $exception->getMessage());
            }
        }

        return $this->render('update-external-id', [
            'model' => $form,
            'property' => $property,
        ]);
    }

    public function actionDelete($id)
    {
        try {
            $this->service->delete($id);
            Yii::$app->session->setFlash('info', 'Свойство успешно удалено');
            return $this->redirect(['index']);
        } catch (\DomainException $exception) {
            Yii::$app->errorHandler->logException($exception);
            Yii::$app->session->setFlash('danger', $exception->getMessage());
            return $this->redirect(['view', 'id' => $id]);
        }
    }

    /***
     * @param $id
     * @return Property
     * @throws NotFoundHttpException
     */
    protected function findModel($id)
    {
        if (($model = Property::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Свойство не найдено');
    }

}