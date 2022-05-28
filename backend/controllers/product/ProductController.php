<?php

namespace backend\controllers\product;

use backend\forms\product\ProductSearch;
use backend\helpers\roles\SupportRoleHelper;
use common\rbac\Roles;
use core\forms\product\ProductBulkUpdateForm;
use core\forms\product\ProductCreateImportForm;
use core\forms\product\ProductImportForm;
use core\forms\product\ProductMetaForm;
use core\forms\product\ProductStatusForm;
use core\forms\product\UrlForm;
use core\helpers\bulk\Bulk;
use core\readModels\RulesTemplateReadRepository;
use core\services\product\ProductBulkAction;
use core\services\product\ProductService;
use Yii;
use core\entities\product\Product;
use core\forms\product\ProductForm;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;

class ProductController extends Controller
{
    private $service;
    private $bulkService;
    private $rulesTemplates;

    public function __construct(
        $id,
        $module,
        ProductService $service,
        ProductBulkAction $bulkService,
        RulesTemplateReadRepository $rulesTemplates,
        $config = []
    )
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
        $this->bulkService = $bulkService;
        $this->rulesTemplates = $rulesTemplates;
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
                        'allow' => true,
                        'actions' => ['index', 'view'],
                        'roles' => [Roles::ROLE_SUPPORT],
                        'matchCallback' => SupportRoleHelper::readOnlyMatchCallback(),
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'hide' => ['POST'],
                    'display' => ['POST'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $searchModel = new ProductSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCreate()
    {
        $form = new ProductForm();

        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $product = $this->service->addByForm($form);
                Yii::$app->session->setFlash('info', 'Товар успешно добавлен');
                return $this->redirect(['view', 'id' => $product->id]);
            } catch (\DomainException $exception) {
                Yii::$app->errorHandler->logException($exception);
                Yii::$app->session->setFlash('danger', $exception->getMessage());
            }
        }

        return $this->render('create', [
            'model' => $form,
            'rulesTemplates' => $this->rulesTemplates->getForDisplay(),
        ]);
    }

    public function actionUpdate($id)
    {
        $product = $this->findModel($id);
        $form = new ProductForm($product);

        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->editByForm($form, $id);
                Yii::$app->session->setFlash('info', 'Товар успешно отредактирован');
                return $this->redirect(['view', 'id' => $id]);
            } catch (\DomainException $exception) {
                Yii::$app->errorHandler->logException($exception);
                Yii::$app->session->setFlash('danger', $exception->getMessage());
            }
        }

        return $this->render('update', [
            'model' => $form,
            'product' => $product,
            'rulesTemplates' => $this->rulesTemplates->getForDisplay(),
        ]);
    }

    public function actionUrl($id)
    {
        $product = $this->findModel($id);
        $form = new UrlForm($product);

        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->editUrl($form, $id);
                Yii::$app->session->setFlash('info', 'Ссылка изменена');
                return $this->redirect(['view', 'id' => $id]);
            } catch (\DomainException $exception) {
                Yii::$app->errorHandler->logException($exception);
                Yii::$app->session->setFlash('danger', $exception->getMessage());
            }
        }

        return $this->render('url', [
            'model' => $form,
            'product' => $product,
        ]);
    }

    public function actionStatus($id)
    {
        $product = $this->findModel($id);
        $form = new ProductStatusForm();

        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->editStatus($form->status, $id);
                Yii::$app->session->setFlash('info', 'Статус успешно отредактирован');
                return $this->redirect(['view', 'id' => $id]);
            } catch (\DomainException $exception) {
                Yii::$app->errorHandler->logException($exception);
                Yii::$app->session->setFlash('danger', $exception->getMessage());
            }
        }

        return $this->render('status', [
            'model' => $form,
            'product' => $product,
        ]);
    }

    public function actionBulk()
    {
        $request = Yii::$app->request;
        $action = $request->post("action");
        $selection = (array)Yii::$app->request->post('selection');

        if (empty($selection)) {
            throw new HttpException(400, 'Не выбран ни один товар');
        }

        switch ($action) {
            case "delete":
            {
                $bulkResult = $this->bulkService->remove($selection);
                $result = $bulkResult->prepareForPrint("Успешно удален", "Ошибка при удалении");
                break;
            }
            case "show":
            {
                $bulkResult = $this->bulkService->display($selection);
                $result = $bulkResult->prepareForPrint("Успешно отображен", "Ошибка при изменении");
                break;
            }
            case "hide":
            {
                $bulkResult = $this->bulkService->hide($selection);
                $result = $bulkResult->prepareForPrint("Успешно скрыт", "Ошибка при скрытии");
                break;
            }
            case "updateBulk":
            {
                Yii::$app->session->set(Bulk::SESSION_KEY, $selection);
                return $this->redirect(['update-bulk']);
            }
            default:
            {
                throw new \InvalidArgumentException("Unknown action");
            }
        }

        Yii::$app->session->setFlash('info', $result);
        return $this->redirect(['index']);
    }

    public function actionUpdateBulk()
    {
        $session = Yii::$app->session;
        if (!$session->has(Bulk::SESSION_KEY)) {
            throw new HttpException(400, "Сперва выберите товары, которым менять группу");
        }

        $ids = $session->get(Bulk::SESSION_KEY);
        $form = new ProductBulkUpdateForm();

        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $result = $this->bulkService->update($ids, $form);
                $textResult = $result->prepareForPrint("Изменения успешно сохранены", "Ошибка при редактировании");
                $session->setFlash('info', $textResult);
                return $this->redirect(['index']);
            } catch (\DomainException $exception) {
                Yii::$app->errorHandler->logException($exception);
                Yii::$app->session->setFlash('danger', $exception->getMessage());
            }
        }

        return $this->render('update-bulk', [
            'model' => $form,
            'ids' => $ids,
            'rulesTemplates' => $this->rulesTemplates->getForDisplay(),
        ]);
    }

    public function actionAddImport($id)
    {
        $product = $this->findModel($id);
        if ($product->productImport) {
            return $this->redirect(['update-import', 'id' => $id]);
        }
        $createForm = new ProductCreateImportForm();
        $settingsForm = new ProductImportForm();
        $data = Yii::$app->request->post();

        if ($createForm->load($data) && $settingsForm->load($data)) {
            $isValid = $createForm->validate();
            $isValid = $settingsForm->validate() && $isValid;
            if ($isValid) {
                try {
                    $this->service->createImportSettings($createForm, $settingsForm, $id);
                    Yii::$app->session->setFlash('info', 'Настройки успешно сохранены');
                    return $this->redirect(['view', 'id' => $id]);
                } catch (\DomainException $exception) {
                    Yii::$app->errorHandler->logException($exception);
                    Yii::$app->session->setFlash('danger', $exception->getMessage());
                }
            }
        }

        return $this->render('add-import', [
            'product' => $product,
            'createForm' => $createForm,
            'settingsForm' => $settingsForm,
        ]);
    }

    public function actionUpdateImport($id)
    {
        $product = $this->findModel($id);
        if (!$product->productImport) {
            return $this->redirect(['add-import', 'id' => $id]);
        }
        $form = new ProductImportForm($product->productImport);

        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->editImportSettings($form, $id);
                Yii::$app->session->setFlash('info', 'Настройки провайдера отредактированы');
                return $this->redirect(['view', 'id' => $id]);
            } catch (\DomainException $exception) {
                Yii::$app->errorHandler->logException($exception);
                Yii::$app->session->setFlash('danger', $exception->getMessage());
            }
        }

        return $this->render('update-import', [
            'model' => $form,
            'product' => $product,
        ]);
    }

    public function actionMeta($id)
    {
        $product = $this->findModel($id);
        $form = new ProductMetaForm($product->productMeta);

        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->editMeta($form, $id);
                Yii::$app->session->setFlash('info', 'SEO настройки отредактированы');
                return $this->redirect(['view', 'id' => $id]);
            } catch (\DomainException $exception) {
                Yii::$app->errorHandler->logException($exception);
                Yii::$app->session->setFlash('danger', $exception->getMessage());
            }
        }

        return $this->render('meta', [
            'model' => $form,
            'product' => $product,
        ]);
    }

    public function actionDelete($id)
    {
        try {
            $this->service->remove($id);
            Yii::$app->session->setFlash('info', 'Товар удален');
        } catch (\DomainException $exception) {
            Yii::$app->errorHandler->logException($exception);
            Yii::$app->session->setFlash('danger', $exception->getMessage());
        }

        return $this->redirect(['index']);
    }

    public function actionHide($id)
    {
        try {
            $this->service->hide($id);
            Yii::$app->session->setFlash('info', 'Товар скрыт');
        } catch (\DomainException $exception) {
            Yii::$app->errorHandler->logException($exception);
            Yii::$app->session->setFlash('danger', $exception->getMessage());
        }

        return $this->redirect(['view', 'id' => $id]);
    }

    public function actionDisplay($id)
    {
        try {
            $this->service->display($id);
            Yii::$app->session->setFlash('info', 'Товар отображен');
        } catch (\DomainException $exception) {
            Yii::$app->errorHandler->logException($exception);
            Yii::$app->session->setFlash('danger', $exception->getMessage());
        }

        return $this->redirect(['view', 'id' => $id]);
    }

    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * @param integer $id
     * @return Product the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Product::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException("Товар не найден");
    }
}