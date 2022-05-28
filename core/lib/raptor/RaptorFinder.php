<?php

namespace core\lib\raptor;

use core\entities\product\dto\ProductFromProvider;
use core\entities\product\Product;
use core\lib\productProvider\FinderInterface;
use core\lib\productProvider\ProductBuffer;
use core\lib\productProvider\ProductNotFoundException;
use core\lib\productProvider\RetrieveItem;

class RaptorFinder implements FinderInterface
{
    use ProductList;

    private $buffer;

    public function __construct(ProductBuffer $buffer)
    {
        $this->buffer = $buffer;
    }

    public function get(Product $product): ProductFromProvider
    {
        $productList = $this->buffer->getOrAdd(1, function () {
            return self::getRandomiseList();
        });

        $product = RetrieveItem::retrieve($productList, "id", $product->productImport->shop_item_id);

        if ($product === false) {
            throw new ProductNotFoundException("Product not found");
        }

        return new ProductFromProvider($product['id'],
            $product['name'],
            $product['miniature'],
            $product['description'],
            $product['price'],
            $product['minimumOrder'],
            $product['quantity'],
            $product['purchaseCounter']);
    }

}