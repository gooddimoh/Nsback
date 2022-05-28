<?php

namespace core\lib\productProvider;

use core\entities\product\dto\ProductFromProvider;
use core\entities\shop\Shop;

interface ImportInterface
{

    /**
     * @return ProductFromProvider[]
     */
    public function getProducts(Shop $shop);

}