<?php

namespace backend\controllers\content;

use common\rbac\Roles;
use Yii;
use core\entities\content\Page;
use core\forms\content\PageForm;
use core\services\page\PageService;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class PageController extends Controller
{
    private $service;

    public function __construct($id, $module, PageService $service, $config = [])
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
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'public' => ['POST'],
                    'draft' => ['POST'],
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->render('index', [
            'dataProvider' => new ActiveDataProvider([
                'query' => Page::find()->andWhere(['status' => [Page::STATUS_PUBLIC, Page::STATUS_DRAFT]]),
            ])
        ]);
    }

    public function actionCreate()
    {
        $form = new PageForm();

        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->add($form);
                Yii::$app->session->setFlash('info', 'Страница создана');
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

    public function actionUpdate($slug)
    {
        $page = $this->findModel($slug);
        $form = new PageForm($page);

        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->edit($slug, $form);
                Yii::$app->session->setFlash('info', "Страница отредактирована");
                return $this->redirect(['index']);
            } catch (\DomainException $exception) {
                Yii::$app->errorHandler->logException($exception);
                Yii::$app->session->setFlash('danger', $exception->getMessage());
            }
        }

        return $this->render('update', [
            'model' => $form,
            'page' => $page,
        ]);
    }

    public function actionPublic($slug)
    {
        try {
            $this->service->public($slug);
            Yii::$app->session->setFlash('success', 'Страница опубликована!');
        } catch (\DomainException $exception) {
            Yii::$app->errorHandler->logException($exception);
            Yii::$app->session->setFlash('danger', $exception->getMessage());
        }

        return $this->redirect(['index']);
    }

    public function actionDraft($slug)
    {
        try {
            $this->service->draft($slug);
            Yii::$app->session->setFlash('info', 'Страница помещена в черновик');
        } catch (\DomainException $exception) {
            Yii::$app->errorHandler->logException($exception);
            Yii::$app->session->setFlash('danger', $exception->getMessage());
        }

        return $this->redirect(['index']);
    }

    public function actionDelete($slug)
    {
        try {
            $this->service->remove($slug);
            Yii::$app->session->setFlash('info', 'Страница удалена');
        } catch (\DomainException $exception) {
            Yii::$app->errorHandler->logException($exception);
            Yii::$app->session->setFlash('danger', $exception->getMessage());
        }

        return $this->redirect(['index']);
    }


    /**
     * @param string $slug
     * @return Page the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($slug)
    {
        if (($model = Page::findOne(['slug' => $slug])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Страница не найдена');
    }
}