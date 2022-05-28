<?php

namespace backend\controllers\shop;

use common\rbac\Roles;
use core\entities\shop\Coupon;
use core\forms\shop\CouponForm;
use Yii;
use backend\forms\shop\CouponSearch;
use core\services\shop\CouponService;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class CouponController extends Controller
{
    private $service;

    public function __construct($id, $module, CouponService $service, array $config = [])
    {
        $this->service = $service;
        parent::__construct($id, $module, $config);
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
                ],
            ],
        ];
    }
    
    public function actionIndex()
    {
        $searchModel = new CouponSearch();
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
        ]);
    }

    public function actionCreate()
    {
        $form = new CouponForm();

        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $coupon = $this->service->add($form);
                Yii::$app->session->setFlash('info', 'Купон успешно создан');
                return $this->redirect(['view', 'id' => $coupon->id]);
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
        $coupon = $this->findModel($id);
        $form = new CouponForm($coupon);

        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->edit($id, $form);
                Yii::$app->session->setFlash('success', 'Успешно изменено');
                return $this->redirect(['view', 'id' => $coupon->id]);
            } catch (\DomainException $exception) {
                Yii::$app->errorHandler->logException($exception);
                Yii::$app->session->setFlash('danger', $exception->getMessage());
            }
        }

        return $this->render('update', [
            'model' => $form,
            'coupon' => $coupon,
        ]);
    }

    public function actionDelete($id)
    {
        try {
            $this->service->delete($id);
            Yii::$app->session->setFlash('success', 'Купон успешно удалён');
        } catch (\DomainException $exception) {
            Yii::$app->errorHandler->logException($exception);
            Yii::$app->session->setFlash('danger', $exception->getMessage());
        }

        return $this->redirect(['index']);
    }

    /***
     * @param $id
     * @return Coupon
     * @throws NotFoundHttpException
     */
    protected function findModel($id)
    {
        if (($model = Coupon::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Купон не найден');
    }

}