<?php

namespace core\repositories\shop;

use core\entities\shop\Shop;
use core\repositories\exceptions\NotFoundException;

class ShopRepository
{
    /**
     * @param $id
     * @return Shop
     */
    public function get($id)
    {
        if (!$entity = Shop::findOne($id)) {
            throw new NotFoundException('Shop is not found.');
        }
        return $entity;
    }

    public function save(Shop $entity)
    {
        if (!$entity->save()) {
            throw new \RuntimeException('Saving error.');
        }
    }

    public function remove(Shop $entity)
    {
        if (!$entity->delete()) {
            throw new \RuntimeException('Removing error.');
        }
    }
}