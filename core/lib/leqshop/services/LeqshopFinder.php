<?php /** @noinspection DuplicatedCode */


namespace core\lib\leqshop\services;

use core\entities\product\dto\ProductFromProvider;
use core\entities\product\dto\Meta;
use core\entities\product\Product;
use core\lib\productProvider\ProductBuffer;
use core\lib\productProvider\ProductNotFoundException;
use core\lib\productProvider\RetrieveItem;
use core\lib\productProvider\FinderInterface;
use core\lib\leqshop\LeqshopClient;
use yii\httpclient\Client;


class LeqshopFinder implements FinderInterface
{
    private $buffer;

    public function __construct(ProductBuffer $buffer)
    {
        $this->buffer = $buffer;
    }

    public function get(Product $product): ProductFromProvider
    {
        $leqshopClient = self::makeClient($product);
        $leqshop = $product->productImport->shop->leqshop;

        $providerProductList = $this->buffer->getOrAdd($leqshop->shop_id, function () use ($leqshopClient, $leqshop) {
            return $leqshopClient->getProduct($leqshop->product_key);
        });

        $providerProduct = RetrieveItem::retrieve($providerProductList, "id", $product->productImport->shop_item_id);

        if (!$providerProduct) {
            throw new ProductNotFoundException("[NF-1] GID:{$product->id}) not found in provider list\n");
        }

        $providerProductObject = new ProductFromProvider(
            $providerProduct['id'],
            $providerProduct['name'],
            $providerProduct['icon'],
            $providerProduct['description'],
            $providerProduct['price_wmr'],
            $providerProduct['minimal_order'],
            $providerProduct['count'],
            $providerProduct['count_sell']
        );
        if (!empty($providerProduct['seo_title'])) {
            $providerProductObject->setMeta(new Meta($providerProduct['seo_title'], $providerProduct['seo_desc'], $providerProduct['keywords']));
        }

        return $providerProductObject;
    }

    protected static function makeClient(Product $product)
    {
        if (empty($product->productImport->shop->leqshop)) {
            throw new \RuntimeException("Product has wrong provider");
        }
        $leq = $product->productImport->shop->leqshop;
        return new LeqshopClient($leq->domain, $leq->api_key_public, $leq->api_key_private, new Client());
    }
}