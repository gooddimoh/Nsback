<?php

namespace backend\controllers\product;

use common\rbac\Roles;
use core\entities\product\RulesTemplate;
use core\services\product\RulesTemplateService;
use core\repositories\product\RulesTemplateRepository;
use core\forms\product\RulesTemplateForm;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use himiklab\sortablegrid\SortableGridAction;

class RulesTemplateController extends Controller
{
    private $service;

    public function __construct($id, $module, RulesTemplateService $service, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
    }

    public function actions()
    {
        return [
            'sort' => [
                'class' => SortableGridAction::class,
                'modelName' => RulesTemplate::class,
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
        return $this->render('index', [
            'dataProvider' => new ActiveDataProvider([
                'query' => RulesTemplate::find(),
                'sort' => ['defaultOrder' => ['position' => SORT_ASC,]]
            ])
        ]);
    }

    public function actionCreate()
    {
        $form = new RulesTemplateForm();

        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $template = $this->service->add($form);
                return $this->redirect(['view', 'id' => $template->id]);
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
        $template = $this->findModel($id);
        $form = new RulesTemplateForm($template);

        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->edit($form, $id);
                return $this->redirect(['view', 'id' => $id]);
            } catch (\DomainException $exception) {
                Yii::$app->errorHandler->logException($exception);
                Yii::$app->session->setFlash('danger', $exception->getMessage());
            }
        }

        return $this->render('update', [
            'template' => $template,
            'model' => $form,
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
        try {
            $this->service->delete($id);
            Yii::$app->session->setFlash('info', "Шаблон удален");
        } catch (\DomainException $exception) {
            Yii::$app->errorHandler->logException($exception);
            Yii::$app->session->setFlash('danger', $exception->getMessage());
        }

        return $this->redirect(['index']);
    }

    /**
     * @param integer $id
     * @return RulesTemplate the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = RulesTemplate::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Шаблон не найден');
    }

}