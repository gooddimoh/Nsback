<?php

namespace core\lib\djekxa\services;

use core\entities\product\dto\ProductFromProvider;
use core\entities\product\Product;
use core\lib\djekxa\DjekxaClient;
use core\lib\productProvider\ProductBuffer;
use core\lib\productProvider\ProductNotFoundException;
use core\lib\productProvider\RetrieveItem;
use core\lib\productProvider\FinderInterface;

class DjekxaFinder implements FinderInterface
{
    private $client;
    private $buffer;

    public function __construct(DjekxaClient $client, ProductBuffer $buffer)
    {
        $this->client = $client;
        $this->buffer = $buffer;
    }

    public function get(Product $product) : ProductFromProvider
    {
        $providerProductList = $this->buffer->getOrAdd(1, function ()  {
            return $this->client->getProduct();
        });
        $providerProduct = RetrieveItem::retrieve($providerProductList, "id", $product->productImport->shop_item_id);

        if (!$providerProduct) {
            throw new ProductNotFoundException("[NF-1] GID #{$product->id}) not found in provider list\n");
        }

        $g = $providerProduct;
        return new ProductFromProvider($g['id'], $g['title'], null, $g['description'], $g['price_rub'], $g['min_count'], $g['count'], null);
    }

}