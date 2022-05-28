<?php

namespace backend\controllers\product;

use backend\forms\product\GroupSearch;
use common\rbac\Roles;
use core\entities\product\Group;
use core\forms\product\GroupForm;
use core\services\product\GroupService;
use himiklab\sortablegrid\SortableGridAction;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class GroupController extends Controller
{
    private $service;

    public function __construct($id, $module, GroupService $service, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
    }

    public function actions()
    {
        return [
            'sort' => [
                'class' => SortableGridAction::class,
                'modelName' => Group::class,
            ],
        ];
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

    public function actionIndex()
    {
        $searchModel = new GroupSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionUpdate($id)
    {
        $group = $this->findModel($id);
        $form = new GroupForm($group);

        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->edit($id, $form);
                Yii::$app->session->setFlash('info', 'Группа успешно отредактирована');
                return $this->redirect(['view', 'id' => $id]);
            } catch (\DomainException $exception) {
                Yii::$app->errorHandler->logException($exception);
                Yii::$app->session->setFlash('danger', $exception->getMessage());
            }
        }

        return $this->render('update', [
            'model' => $form,
            'group' => $group,
        ]);
    }

    public function actionCreate()
    {
        $form = new GroupForm();

        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->add($form);
                Yii::$app->session->setFlash('info', 'Группа успешно создана');
                return  $this->redirect(['index']);
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
     * @return Group the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Group::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Группа не найдена');
    }
}