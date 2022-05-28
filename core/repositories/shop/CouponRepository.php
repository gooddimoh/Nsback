<?php

namespace core\repositories\shop;

use core\entities\shop\Coupon;
use core\repositories\exceptions\NotFoundException;

class CouponRepository
{
    /**
     * @param $id
     * @return Coupon
     */
    public function get($id)
    {
        if (!$entity = Coupon::findOne($id)) {
            throw new NotFoundException('Coupon is not found.');
        }
        return $entity;
    }

    public function save(Coupon $entity)
    {
        if (!$entity->save()) {
            throw new \RuntimeException('Saving error.');
        }
    }

    public function remove(Coupon $entity)
    {
        if (!$entity->delete()) {
            throw new \RuntimeException('Removing error.');
        }
    }

}