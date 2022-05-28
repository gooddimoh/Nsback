<?php

namespace frontend\modules\point\controllers;

use core\forms\order\OrderForm;
use core\services\order\CheckReadinessService;
use frontend\forms\Product\ProductSearch;
use Yii;
use core\entities\product\Product;
use core\services\order\BuyService;
use yii\filters\VerbFilter;
use yii\rest\Controller;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;

class ProductController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'buy' => ['POST'],
                ],
            ],
        ];
    }

    public function actionView($id)
    {
        $product = $this->findModel($id);
        return [
            'product' => [
                'id' => $product->id,
                'name' => $product->name,
                'category' => $product->group->category->name,
                'price' => $product->price,
            ]
        ];
    }

    public function actionShowcase()
    {
        $request = Yii::$app->request;
        $searchParams = $request->post("searchParams");

        $productSearch = new ProductSearch();
        $productSearch->setExcludedIds($request->post("existing", []));
        $productSearch->group_id = $request->post("gid");
        unset($searchParams['group_id']); // Приоритет на gid из блока "Show More"

        $dataProvider = $productSearch->search($searchParams);

        $formattedResult = array_map(function (Product $product) {
            return $this->renderFile("@frontend/views/_parts/showcase-product.php", ['model' => $product, 'disableImgLazyLoad' => true]);
        }, $dataProvider->query->limit(null)->addOrderBy($dataProvider->sort->getOrders())->all());

        return [
            'html_products' => $formattedResult,
        ];
    }

    /**
     * @param integer $id
     * @return Product the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Product::findOne(['id' => $id, 'status' => Product::PUBLIC_STATUS])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Товар не найден');
    }

}