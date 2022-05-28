<?php

namespace console\controllers;

use core\entities\shop\Shop;
use core\lib\leqshop\LeqshopClient;
use yii\console\Controller;
use yii\console\ExitCode;
use yii\httpclient\Client;
use yii\web\NotFoundHttpException;

class LeqshopController extends Controller
{

    public function actionShopList()
    {
        print_r(Shop::find()->asArray()->where(['status' => Shop::STATUS_ACTIVE])->all());
    }

    public function actionGetProduct($shopId, $productId)
    {
        foreach ($this->getAllProducts($shopId) as $product) {
            if ($product['id'] == $productId) {
                print_r($product);
                return ExitCode::OK;
            }
        }

        throw new \Exception("Product not found");
    }

    protected function getAllProducts($shopId)
    {
        $shop = $this->findModel($shopId);
        $client = self::makeClient($shop);
        return $client->getProduct($shop->leqshop->product_key);
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

        throw new NotFoundHttpException('Страница не найдена');
    }

    protected static function makeClient(Shop $shop)
    {
        if (empty($shop->leqshop)) {
            throw new \RuntimeException("Order has wrong provider");
        }
        $leq = $shop->leqshop;
        return new LeqshopClient($leq->domain, $leq->api_key_public, $leq->api_key_private, new Client());
    }

    public function actionProducts($shopId)
    {
        print_r($this->getAllProducts($shopId));
    }


}