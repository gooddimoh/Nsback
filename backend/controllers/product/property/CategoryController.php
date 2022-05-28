<?php

namespace backend\controllers\product\property;

use core\entities\product\property\PropertyCategory;
use core\forms\product\property\PropertyCategoryForm;
use core\forms\product\property\PropertyExternalIdForm;
use core\services\product\property\PropertyCategoryService;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class CategoryController extends Controller
{
    private PropertyCategoryService $service;

    public function __construct($id, $module, PropertyCategoryService $service, array $config = [])
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
            'query' => PropertyCategory::find(),
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
        $form = new PropertyCategoryForm();

        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $group = $this->service->add($form);
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
        $category = $this->findModel($id);
        $form = new PropertyCategoryForm($category);

        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->edit($id, $form);
                Yii::$app->session->setFlash('success', 'Успешно изменено');
                return $this->redirect(['view', 'id' => $category->id]);
            } catch (\DomainException $exception) {
                Yii::$app->errorHandler->logException($exception);
                Yii::$app->session->setFlash('danger', $exception->getMessage());
            }
        }

        return $this->render('update', [
            'model' => $form,
            'category' => $category,
        ]);
    }

    public function actionUpdateExternalId($id)
    {
        $category = $this->findModel($id);
        $form = new PropertyExternalIdForm($category->external_id);

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
            'category' => $category,
        ]);
    }

    /***
     * @param $id
     * @return PropertyCategory
     * @throws NotFoundHttpException
     */
    protected function findModel($id)
    {
        if (($model = PropertyCategory::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Категория не найдена');
    }

}