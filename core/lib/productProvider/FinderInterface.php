<?php

namespace core\lib\productProvider;

use core\entities\product\dto\ProductFromProvider;
use core\entities\product\Product;

interface FinderInterface
{
    /**
     * @param Product $product
     * @return ProductFromProvider
     * @throws ProductNotFoundException
     */
    public function get(Product $product) : ProductFromProvider;
}