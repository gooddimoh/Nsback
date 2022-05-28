<?php

namespace backend\controllers\product;

use common\rbac\Roles;
use core\services\product\import\ImportTaskService;
use Yii;
use core\entities\import\ImportTask;
use core\forms\import\ImportForm;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class ImportController extends Controller
{
    private $service;

    public function __construct($id, $module, ImportTaskService $service, $config = [])
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

    public function actionIndex()
    {
        return $this->render("index", [
            'dataProvider' => new ActiveDataProvider([
                'query' => ImportTask::find(),
                'sort' => ['defaultOrder' => ['id' => SORT_DESC]],
            ])
        ]);
    }

    public function actionCreate()
    {
        $form = new ImportForm();

        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->create($form);
                Yii::$app->session->setFlash('info', 'Процедура импорта сформирована');
                return $this->redirect(['index']);
            } catch (\DomainException $exception) {
                Yii::$app->errorHandler->logException($exception);
                Yii::$app->session->setFlash('danger', $exception->getMessage());
            }
        }
        
        return $this->render('create', [
            'model' => $form,
        ]);
    }

    public function actionRestart($id)
    {
        try {
            $this->service->restart($id);
            Yii::$app->session->setFlash('info', 'Импорт перезапущен');
        } catch (\DomainException $exception) {
            Yii::$app->errorHandler->logException($exception);
            Yii::$app->session->setFlash('danger', $exception->getMessage());
        }

        return $this->redirect(['index']);
    }

    public function actionLog($id)
    {
        return $this->render("log", [
            'model' => $this->findModel($id),
        ]);
    }
    
    /**
     * @param integer $id
     * @return ImportTask the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ImportTask::findOne($id)) !== null) {
            return $model;
        }
    
        throw new NotFoundHttpException('Импорт не найден');
    }
}