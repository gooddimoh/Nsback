<?php

namespace backend\controllers\product;

use common\rbac\Roles;
use himiklab\sortablegrid\SortableGridAction;
use Yii;
use core\entities\product\Category;
use core\forms\product\CategoryForm;
use core\services\product\CategoryService;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class CategoryController extends Controller
{
    private $service;

    public function __construct($id, $module, CategoryService $service, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
    }

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

    public function actions()
    {
        return [
            'sort' => [
                'class' => SortableGridAction::class,
                'modelName' => Category::class,
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->render("index", [
            'dataProvider' => new ActiveDataProvider([
                'query' => Category::find(),
                'sort' => ['defaultOrder' => ['position' => SORT_ASC]],
                'pagination' => [
                    'pageSizeLimit' => [1, 500],
                ],
            ])
        ]);
    }

    public function actionUpdate($id)
    {
        $category = $this->findModel($id);
        $form = new CategoryForm($category);

        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->edit($id, $form);
                Yii::$app->session->setFlash('info', 'Категория успешно отредактирована');
                return $this->redirect(['view', 'id' => $id]);
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

    public function actionCreate()
    {
        $form = new CategoryForm();

        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $category = $this->service->add($form);
                Yii::$app->session->setFlash('info', 'Категория успешно создана');
                return $this->redirect(['view', 'id' => $category->id]);
            } catch (\DomainException $exception) {
                Yii::$app->errorHandler->logException($exception);
                Yii::$app->session->setFlash('danger', $exception->getMessage());
            }
        }

        return $this->render('create', [
            'model' => $form,
        ]);
    }

    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }


    /**
     * @param integer $id
     * @return Category the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Category::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Категория не найдена');
    }
}