<?php


namespace core\lib\leqshop\services;

use core\entities\product\dto\ProductFromProvider;
use core\entities\product\dto\Meta;
use core\entities\shop\Shop;
use core\lib\productProvider\ImportInterface;
use core\lib\leqshop\LeqshopClient;
use yii\httpclient\Client;

class LeqshopImport implements ImportInterface
{
    public function getProducts(Shop $shop)
    {
        $client = self::makeClient($shop);
        $productRaw = $client->getProduct($shop->leqshop->product_key);
        return array_map(function ($product) {
            $result = new ProductFromProvider(
                $product['id'],
                $product['name'],
                $product['icon'],
                $product['description'],
                $product['price_wmr'],
                $product['minimal_order'],
                $product['count'],
                $product['count_sell']
            );

            if (!empty($product['seo_title']) || !empty($product['seo_desc']) || !empty($product['keywords'])) {
                $result->setMeta(new Meta($product['seo_title'], $product['seo_desc'], $product['keywords']));
            }

            return $result;
        }, $productRaw);
    }

    protected static function makeClient(Shop $shop)
    {
        if (empty($shop->leqshop)) {
            throw new \RuntimeException("Product has wrong provider");
        }
        $leq = $shop->leqshop;
        return new LeqshopClient($leq->domain, $leq->api_key_public, $leq->api_key_private, new Client());
    }

}