<?php

namespace backend\controllers;

use backend\forms\user\UserSearch;
use backend\helpers\roles\SupportRoleHelper;
use common\rbac\Roles;
use common\rbac\RolesHierarchy;
use core\entities\user\User;
use core\forms\user\BalanceOperationForm;
use core\forms\user\ChangeUserPasswordForm;
use core\forms\user\UserUpdateForm;
use core\lib\attention\operations\OperationMinus;
use core\lib\attention\operations\OperationPlus;
use core\lib\attention\OperationMistakePrevention;
use core\services\user\BalanceService;
use core\services\user\UserService;
use Yii;
use yii\filters\AccessControl;
use yii\helpers\Html;
use yii\rbac\Role;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;

class UserController extends Controller
{
    private $balanceService;
    private $service;

    public function __construct($id, $module, BalanceService $balanceService, UserService $userService, array $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->balanceService = $balanceService;
        $this->service = $userService;
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
                    [
                        'actions' => ['index', 'view'],
                        'allow' => true,
                        'roles' => [Roles::ROLE_SUPPORT],
                        'denyCallback' => function () {
                            throw new ForbiddenHttpException("Вам доступен только просмотр данных");
                        },
                        'matchCallback' => SupportRoleHelper::readOnlyMatchCallback(),
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);


        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionUpdate($id)
    {
        $user = $this->findModel($id);
        $form = new UserUpdateForm($user);

        if (!RolesHierarchy::isUserHigher(Yii::$app->user->id, $user->id)) {
            throw new ForbiddenHttpException("Вы не можете редактировать профиль старшему по званию.");
        }


        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->update($id, $form);
                Yii::$app->session->setFlash('info', 'Пользователь успешно отредактирован');
                return $this->redirect(['view', 'id' => $id]);
            } catch (\DomainException $exception) {
                Yii::$app->errorHandler->logException($exception);
                Yii::$app->session->setFlash('danger', $exception->getMessage());
            }
        }

        return $this->render('update', [
            'model' => $form,
            'user' => $user,
        ]);
    }

    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionAddBalance($id)
    {
        $user = $this->findModel($id);
        $form = new BalanceOperationForm();

        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->balanceService->addBalanceByForm($user->id, $form);
                Yii::$app->session->setFlash('success', self::createTransferMessage($form->sum, false));
                return $this->redirect(['view', 'id' => $id]);
            } catch (\DomainException $exception) {
                Yii::$app->errorHandler->logException($exception);
                Yii::$app->session->setFlash('danger', $exception->getMessage());
            }
        }

        return $this->render('add-balance', [
            'model' => $form,
            'user' => $user,
        ]);
    }

    public function actionWriteOffBalance($id)
    {
        $user = $this->findModel($id);
        $form = new BalanceOperationForm();

        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->balanceService->writeOffBalanceByForm($user->id, $form);
                Yii::$app->session->setFlash('info', self::createTransferMessage($form->sum, true));
                return $this->redirect(['view', 'id' => $id]);
            } catch (\DomainException $exception) {
                Yii::$app->errorHandler->logException($exception);
                Yii::$app->session->setFlash('danger', $exception->getMessage());
            }
        }

        return $this->render('write-off-balance', [
            'model' => $form,
            'user' => $user,
        ]);
    }

    public function actionChangePassword($id)
    {
        $user = $this->findModel($id);
        $model = new ChangeUserPasswordForm();

        if (!RolesHierarchy::isUserHigher(Yii::$app->user->id, $user->id)) {
            throw new ForbiddenHttpException("Вы не можете сменить пароль старшему по званию.");
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            try {
                $this->service->changePassword($id, $model);
                Yii::$app->session->setFlash('success', 'Пароль успешно изменен');
            } catch (\DomainException $exception) {
                Yii::$app->errorHandler->logException($exception);
                Yii::$app->session->setFlash('danger', $exception->getMessage());

            }
            return $this->refresh();
        }

        return $this->render('change-password', [
            'model' => $model,
            'user' => $user,
        ]);
    }


    /**
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Пользователь не найден');
    }

    protected static function createTransferMessage($sum, $isWriteOff)
    {
        $operation = !$isWriteOff ? new OperationPlus("Сумма {sum} успешно начислена на баланс")
            : new OperationMinus("Сумма {sum} успешно списана с баланса");
        $operationMistakePrevention = new OperationMistakePrevention($operation, 1000);

        return $operationMistakePrevention->create($sum);
    }

}
