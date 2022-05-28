<?php

namespace core\entities\product\events;

use core\entities\product\Product;

class ProductPassedModeration
{
    public $product;

    public function __construct(Product $product)
    {
        $this->product = $product;
    }

}