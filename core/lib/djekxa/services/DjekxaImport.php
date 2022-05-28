<?php

namespace core\lib\djekxa\services;

use core\entities\product\dto\ProductFromProvider;
use core\entities\shop\Shop;
use core\lib\djekxa\DjekxaClient;
use core\lib\productProvider\ImportInterface;

class DjekxaImport implements ImportInterface
{
    private $client;

    public function __construct(DjekxaClient $client)
    {
        $this->client = $client;
    }

    public function getProducts(Shop $shop)
    {
        $productRaw = $this->client->getProduct();

        return array_map(function ($g){
            return new ProductFromProvider($g['id'], $g['title'], null, $g['description'], $g['price_rub'], $g['min_count'], $g['count'], null);
        }, $productRaw);
    }
}