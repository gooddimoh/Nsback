<?php

namespace backend\controllers\shop;

use common\rbac\Roles;
use core\forms\shop\LeqshopForm;
use core\services\shop\ShopBlockService;
use core\services\shop\ShopService;
use Yii;
use core\entities\shop\Shop;
use core\forms\shop\ShopForm;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;

class ShopController extends Controller
{
    private $service;
    private $blocker;

    public function __construct($id, $module, ShopService $service, ShopBlockService $blocker, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
        $this->blocker = $blocker;

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
                    'block' => ['POST'],
                    'unblock' => ['POST'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->render('index', [
            'dataProvider' => new ActiveDataProvider([
                'query' => Shop::find(),
                'sort' => ['defaultOrder' => ['id' => SORT_DESC]],
            ])
        ]);
    }

    public function actionCreate()
    {
        $form = new ShopForm();

        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $shop = $this->service->add($form);
                Yii::$app->session->setFlash('info', 'Магазин успешно создан');
                return $this->redirect(['view', 'id' => $shop->id]);
            } catch (\DomainException $exception) {
                Yii::$app->errorHandler->logException($exception);
                Yii::$app->session->setFlash('danger', $exception->getMessage());
            }
        }

        return $this->render('create', [
            'model' => $form,
        ]);
    }

    public function actionBlock($id)
    {
        try {
            $shop = $this->findModel($id);
            $this->blocker->block($id);
            Yii::$app->session->setFlash('success', "Магазин $shop->name был заблокирован. Товар магазина будет отображаться, но \"Не в наличии\"");
        } catch (\DomainException $exception) {
            Yii::$app->errorHandler->logException($exception);
            Yii::$app->session->setFlash('danger', $exception->getMessage());
        }

        return $this->redirect(['index']);
    }

    public function actionUnblock($id)
    {
        try {
            $shop = $this->findModel($id);
            $this->blocker->unblock($id);
            Yii::$app->session->setFlash('success', "Магазин $shop->name разблокирован. Товары магазина доступы к покупке. 
            В течении нескольких минут будет актуализирована информация о товаре поставщика.");
        } catch (\DomainException $exception) {
            Yii::$app->errorHandler->logException($exception);
            Yii::$app->session->setFlash('danger', $exception->getMessage());
        }

        return $this->redirect(['index']);
    }

    public function actionLeqshop($id)
    {
        $shop = $this->findModel($id);
        $form = new LeqshopForm($shop->leqshop);

        if (!$shop->isPlatformLeqshop()) {
            throw new ForbiddenHttpException("Данный магазин не связан с Leqshop");
        }

        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->setLeqshop($id, $form);
                Yii::$app->session->setFlash('info', 'Данные успешно отредактированы');
                return $this->redirect(['view', 'id' => $id]);
            } catch (\DomainException $exception) {
                Yii::$app->errorHandler->logException($exception);
                Yii::$app->session->setFlash('danger', $exception->getMessage());
            }
        }

        return $this->render('leqshop', [
            'model' => $form,
            'shop' => $shop,
        ]);
    }

    public function actionUpdate($id)
    {
        $shop = $this->findModel($id);
        $form = new ShopForm($shop);

        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->edit($id, $form);
                Yii::$app->session->setFlash('info', 'Магазин успешно отредактирован');
                return $this->redirect(['view', 'id' => $id]);
            } catch (\DomainException $exception) {
                Yii::$app->errorHandler->logException($exception);
                Yii::$app->session->setFlash('danger', $exception->getMessage());
            }
        }

        return $this->render('update', [
            'model' => $form,
            'shop' => $shop,
        ]);
    }

    public function actionView($id)
    {
        return $this->render("view", [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * @param integer $id
     * @return Shop the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Shop::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Магазин не найден');
    }
}