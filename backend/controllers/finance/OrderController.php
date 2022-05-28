<?php

namespace backend\controllers\finance;

use backend\forms\order\OrderFindSingleForm;
use backend\helpers\UrlNavigatorBackend;
use common\rbac\Roles;
use core\entities\order\Order;
use core\forms\order\OrderAssignForm;
use core\forms\order\OrderResultForm;
use core\forms\order\OrderStatusForm;
use core\helpers\order\RefundHelper;
use core\readModels\OrderReadRepository;
use core\services\order\AssignGuestOrderService;
use core\services\rbac\RoleDownloadLimitRegulator;
use core\services\order\RefundService;
use core\services\order\OrderService;
use Yii;
use backend\forms\order\OrderSearch;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use backend\forms\order\RefundForm;

class OrderController extends Controller
{
    private $service;
    private $orders;
    private $cancelService;
    private $assignGuestOrderService;
    private $managerDownload;

    public function __construct(
        $id,
        $module,
        OrderService $service,
        OrderReadRepository $orders,
        RefundService $cancelService,
        AssignGuestOrderService $assignGuestOrderService,
        RoleDownloadLimitRegulator $managerDownload,
        $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
        $this->orders = $orders;
        $this->cancelService = $cancelService;
        $this->assignGuestOrderService = $assignGuestOrderService;
        $this->managerDownload = $managerDownload;
    }

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['change-status'],
                'rules' => [
                    [
                        'actions' => ['change-status'],
                        'allow' => true,
                        'roles' => [Roles::ROLE_SENIOR_MANAGER, Roles::ROLE_ADMINISTRATOR],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'clear-error' => ['POST'],
                    'download' => ['POST'],
                    'show-result' => ['POST'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $searchModel = new OrderSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'errorQuantity' => $this->orders->countError(),
            'suspendedQuantity' => $this->orders->countSuspend(),
        ]);
    }

    public function actionChangeStatus($id)
    {
        $order = $this->findModel($id);
        $form = new OrderStatusForm($order);

        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->changeStatus($id, $form->status);
                Yii::$app->session->setFlash('success', 'Статус успешно изменен');
                return $this->redirect(['view', 'id' => $id]);
            } catch (\DomainException $exception) {
                Yii::$app->errorHandler->logException($exception);
                Yii::$app->session->setFlash('danger', $exception->getMessage());
            }
        }

        return $this->render('change-status', [
            'model' => $form,
            'order' => $order,
        ]);
    }

    public function actionClearError($id)
    {
        try {
            $this->service->clearError($id);
        } catch (\DomainException $exception) {
            Yii::$app->errorHandler->logException($exception);
            Yii::$app->session->setFlash('danger', $exception->getMessage());
        }

        return $this->redirect(['view', 'id' => $id]);
    }

    public function actionAssign($id)
    {
        $order = $this->findModel($id);
        $form = new OrderAssignForm();

        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->assignGuestOrderService->assignByForm($form);
                Yii::$app->session->setFlash('info', 'Заказ успешно привязан');
                return $this->redirect(['view', 'id' => $id]);
            } catch (\DomainException $exception) {
                Yii::$app->errorHandler->logException($exception);
                Yii::$app->session->setFlash('danger', $exception->getMessage());
            }
        }

        return $this->render('assign', [
            'model' => $form,
            'order' => $order,
        ]);
    }

    public function actionRefund($id)
    {
        $order = $this->findModel($id);
        $form = new RefundForm($order);

        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $refund = $this->cancelService->refund($form, $id);
                Yii::$app->session->setFlash('info', 'Возврат успешно оформлен на ' . RefundHelper::methodName($refund->isRefundToBalance()));
                return $this->redirect(['view', 'id' => $id]);
            } catch (\DomainException $exception) {
                Yii::$app->errorHandler->logException($exception);
                Yii::$app->session->setFlash('danger', $exception->getMessage());
            }
        }

        return $this->render('refund', [
            'model' => $form,
            'order' => $order,
        ]);
    }

    public function actionResult($id)
    {
        $order = $this->findModel($id);
        $form = new OrderResultForm();

        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->writeResult($id, $form);
                Yii::$app->session->setFlash('success', 'Результат успешно записан');
                return $this->redirect(['view', 'id' => $id]);
            } catch (\DomainException $exception) {
                Yii::$app->errorHandler->logException($exception);
                Yii::$app->session->setFlash('danger', $exception->getMessage());
            }
        }

        return $this->render("result", [
            'model' => $form,
            'order' => $order,
        ]);
    }

    public function actionView($id = null, $code = null, $email = null)
    {
        $model = $code && $email ? $this->findModelSecure($code, $email) : $this->findModel($id);

        return $this->render('view', [
            'model' => $model,
        ]);
    }

    public function actionDownload($id)
    {
        try {
            $file = $this->managerDownload->download($id, Yii::$app->user->id);
            return \Yii::$app->response->sendFile($file);
        } catch (\DomainException $exception) {
            Yii::$app->errorHandler->logException($exception);
            Yii::$app->session->setFlash('danger', $exception->getMessage());
            return $this->redirect(['view', 'id' => $id]);
        }
    }

    public function actionShowResult()
    {
        try {
            $file = $this->managerDownload->download(Yii::$app->request->post("id"), Yii::$app->user->id);
            return nl2br(file_get_contents($file));
        } catch (\DomainException $exception) {
            Yii::$app->errorHandler->logException($exception);
            Yii::$app->session->setFlash('danger', $exception->getMessage());
            return $this->refresh();
        }
    }

    public function actionShowUrl()
    {
        try {
            return $this->managerDownload->resultUrl(Yii::$app->request->post("id"), Yii::$app->user->id);
        } catch (\DomainException $exception) {
            Yii::$app->errorHandler->logException($exception);
            Yii::$app->session->setFlash('danger', $exception->getMessage());
            return $this->refresh();
        }
    }

    public function actionFindSingle()
    {
        $form = new OrderFindSingleForm();

        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                if (($order = $this->orders->getByCode($form->code)) !== null) {
                    return $this->redirect(UrlNavigatorBackend::viewOrderSecure($order->code, $order->email));
                } else {
                    Yii::$app->session->setFlash('danger', "Заказ {$form->code} не найден");
                    return $this->refresh();
                }
            } catch (\DomainException $exception) {
                Yii::$app->errorHandler->logException($exception);
                Yii::$app->session->setFlash('danger', $exception->getMessage());
            }
        }

        return $this->render('find-single', [
            'model' => $form,
        ]);
    }

    /**
     * @param integer $id
     * @return Order the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Order::findConsiderRole()->andWhere(['id' => $id])->one()) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Заказ не найден');
    }

    protected function findModelSecure($code, $email)
    {
        if (($model = Order::findOne(['code' => $code, 'email' => $email])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Заказ не найден');
    }

}