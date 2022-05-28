<?php

namespace core\repositories\order;

use core\dispatchers\EventDispatcher;
use core\entities\order\Refund;
use core\repositories\exceptions\NotFoundException;

class OrderRefundRepository
{
    private $dispatcher;

    public function __construct(EventDispatcher $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    /**
     * @param $id
     * @return Refund
     */
    public function get($id)
    {
        if (!$entity = Refund::findOne($id)) {
            throw new NotFoundException('Record about order refund not found');
        }
        return $entity;
    }

    public function save(Refund $entity)
    {
        if (!$entity->save()) {
            throw new \RuntimeException('Saving error.');
        }

        $this->dispatcher->dispatchAll($entity->releaseEvents());
    }

    public function remove(Refund $entity)
    {
        if (!$entity->delete()) {
            throw new \RuntimeException('Removing error.');
        }
    }

}