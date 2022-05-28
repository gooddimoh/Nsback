<?php

namespace core\lib\raptor;

use core\entities\product\dto\ProductFromProvider;
use core\entities\shop\Shop;
use core\lib\productProvider\ImportInterface;

class RaptorImport implements ImportInterface
{
    use ProductList;

    public function getProducts(Shop $shop)
    {
        return array_map(function ($item) {
            return new ProductFromProvider($item['id'],
                $item['name'],
                $item['miniature'],
                $item['description'],
                $item['price'],
                $item['minimumOrder'],
                $item['quantity'],
                $item['purchaseCounter']);
        }, self::getRandomiseList());
    }

}