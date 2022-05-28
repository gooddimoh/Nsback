<?php

namespace backend\controllers\finance;

use backend\forms\finance\PromoCodeSearch;
use common\rbac\Roles;
use core\entities\order\PromoCode;
use core\entities\order\PromoCodeActivation;
use core\forms\order\promo\PromoCodeBulkForm;
use core\forms\order\promo\PromoCodeForm;
use core\services\order\PromoCodeService;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class PromoCodeController extends Controller
{
    private $service;

    public function __construct($id, $module, PromoCodeService $service, $config = [])
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
                    'delete' => ['POST'],
                    'activate' => ['POST'],
                    'inactivate' => ['POST'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $searchModel = new PromoCodeSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
            'activations' => new ActiveDataProvider([
                'query' => PromoCodeActivation::find()->where(['promo_id' => $id]),
            ])
        ]);
    }

    public function actionCreate()
    {
        $form = new PromoCodeForm();

        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $entity = $this->service->add($form);
                return $this->redirect(['view', 'id' => $entity->id]);
            } catch (\DomainException $exception) {
                Yii::$app->errorHandler->logException($exception);
                Yii::$app->session->setFlash('danger', $exception->getMessage());
            }
        }

        return $this->render('create', [
            'model' => $form,
        ]);
    }

    public function actionBulkCreate()
    {
        $form = new PromoCodeBulkForm();

        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $result = $this->service->addBulk($form);
                $listOfCodes = array_map(function (PromoCode $promoCode) {
                    return $promoCode->code;
                }, $result);
                Yii::$app->session->setFlash('success', "Промо-коды с процентом {$form->percent}% успешны добавлены: <br>" . implode("<br>", $listOfCodes));
                return $this->refresh();
            } catch (\DomainException $exception) {
                Yii::$app->errorHandler->logException($exception);
                Yii::$app->session->setFlash('danger', $exception->getMessage());
            }
        }

        return $this->render('bulk-create', [
            'model' => $form,
        ]);
    }

    public function actionActivate($id)
    {
        try {
            $this->service->activate($id);
        } catch (\DomainException $exception) {
            Yii::$app->errorHandler->logException($exception);
            Yii::$app->session->setFlash('danger', $exception->getMessage());
        }

        return $this->redirect(['view', 'id' => $id]);
    }

    public function actionInactivate($id)
    {
        try {
            $this->service->inactivate($id);
        } catch (\DomainException $exception) {
            Yii::$app->errorHandler->logException($exception);
            Yii::$app->session->setFlash('danger', $exception->getMessage());
        }

        return $this->redirect(['view', 'id' => $id]);
    }

    public function actionDelete($id)
    {
        try {
            $this->service->delete($id);
        } catch (\DomainException $exception) {
            Yii::$app->errorHandler->logException($exception);
            Yii::$app->session->setFlash('danger', $exception->getMessage());
        }

        return $this->redirect(['index']);
    }

    /**
     * @param integer $id
     * @return PromoCode the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PromoCode::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Страница не найдена');
    }
}
