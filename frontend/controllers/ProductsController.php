<?php

namespace frontend\controllers;

use core\entities\product\Category;
use core\entities\order\Order;
use core\readModels\ProductReadRepository;
use core\readModels\GroupReadRepository;
use core\services\product\ProductService;
use frontend\forms\Product\ProductSearch;
use Yii;
use core\entities\product\Product;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;

class ProductsController extends Controller
{
    public $defaultAction = "catalog";

    private $product;
    private $groups;
    private $service;

    public function __construct(
        $id,
        $module,
        ProductReadRepository $product,
        GroupReadRepository $groups,
        ProductService $service,
        $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->product = $product;
        $this->groups = $groups;
        $this->service = $service;
    }

    public function actionCatalog($group = null)
    {
        $searchModel = new ProductSearch();
        $searchModel->setSortByTop();
        $searchModel->setDefaultPageSize(20);
        $slug = $group;

        if (($groupEntity = $this->groups->get($slug)) !== null) {
            $searchModel->group_id = $groupEntity->id;
        }

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('catalog', [
            'dataProvider' => $dataProvider,
            'searchCategories' => Category::find()->all(),
            'searchModel' => $searchModel,
        ]);
    }

    /**
     * @param null $slug
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionView($slug)
    {
        $product = $this->findModelBySlug($slug);

        return $this->render('view', [
            'product' => $product,
            'similarProducts' => new ActiveDataProvider([
                'query' => $this->product->getSimilarProducts($product->group_id, $product->id),
                'pagination' => false,

            ]),
            'lastOrders' => new ActiveDataProvider([
                'query' => Order::find()->where(['status' => Order::STATUS_COMPLETED])->limit(10),
                'sort' => ['defaultOrder' => ['id' => SORT_DESC]],
                'pagination' => false,
            ])
        ]);
    }


    /**
     * @param string $slug
     * @return Product the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModelBySlug($slug)
    {
        if (($model = Product::findOne(['slug' => $slug, 'status' => Product::PUBLIC_STATUS])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Товар не найден');
    }
}