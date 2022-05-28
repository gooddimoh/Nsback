<?php

namespace core\services\shop;

use core\entities\product\Product;
use core\repositories\product\ProductRepository;
use core\repositories\shop\ShopRepository;

class ShopBlockService
{
    private $shops;
    private $product;

    public function __construct(ShopRepository $shops, ProductRepository $product)
    {
        $this->shops = $shops;
        $this->product = $product;
    }

    public function block($id)
    {
        $shop = $this->shops->get($id);
        $shop->block();

        /** @var $product Product */
        foreach ($this->product->getByShopId($id) as $product) {
            $product->block();
            $this->product->save($product);
        }

        $this->shops->save($shop);
    }

    public function unblock($id)
    {
        $shop = $this->shops->get($id);
        $shop->activate();

        /** @var $product Product */
        foreach ($this->product->getByShopId($id) as $product) {
            $product->activate();
            $this->product->save($product);
        }

        $this->shops->save($shop);
    }



}