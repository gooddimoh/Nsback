<?php

namespace core\repositories\order;

use core\dispatchers\EventDispatcher;
use core\entities\order\Order;
use core\repositories\exceptions\NotFoundException;

class OrderRepository
{
    private $dispatcher;

    public function __construct(EventDispatcher $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    public function get($id)
    {
        return $this->getBy(['id' => $id]);
    }

    public function getByCodeAndEmail($code, $email)
    {
        return $this->getBy(['code' => $code, 'email' => $email]);
    }

    public function getAllGuestOrderByEmail($email)
    {
        return Order::find()->where(['email' => $email])->andWhere(['user_id' => null])->all();
    }

    public function save(Order $entity)
    {
        if (!$entity->save()) {
            throw new \RuntimeException('Saving error.');
        }
        $this->dispatcher->dispatchAll($entity->releaseEvents());
    }

    public function remove(Order $entity)
    {
        if (!$entity->delete()) {
            throw new \RuntimeException('Removing error.');
        }
    }

    /**
     * @param array $condition
     * @return Order
     * @throws NotFoundException
     */
    protected function getBy(array $condition)
    {
        if (!$entity = Order::findOne($condition)) {
            throw new NotFoundException('Order is not found.');
        }
        return $entity;
    }

}