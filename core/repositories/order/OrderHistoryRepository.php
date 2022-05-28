<?php

namespace core\repositories\order;

use core\repositories\exceptions\NotFoundException;
use core\entities\order\OrderHistory;

class OrderHistoryRepository
{
    /**
     * @param $id
     * @return OrderHistory
     */
    public function get($id)
    {
        if (!$entity = OrderHistory::findOne($id)) {
            throw new NotFoundException('Order is not found.');
        }
        return $entity;
    }

    public function save(OrderHistory $entity)
    {
        if (!$entity->save()) {
            throw new \RuntimeException('Saving error.');
        }
    }

    public function remove(OrderHistory $entity)
    {
        if (!$entity->delete()) {
            throw new \RuntimeException('Removing error.');
        }
    }
}