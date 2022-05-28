<?php

namespace core\repositories\order;

use core\entities\payment\Payment;
use core\repositories\exceptions\NotFoundException;
use core\dispatchers\EventDispatcher;

class PaymentRepository
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

    /**
     * @param array $condition
     * @return \core\entities\payment\Payment
     */
    protected function getBy(array $condition)
    {
        if (!$entity = \core\entities\payment\Payment::findOne($condition)) {
            throw new NotFoundException('Payment is not found.');
        }
        return $entity;
    }

    public function save(Payment $entity)
    {
        if (!$entity->save()) {
            throw new \RuntimeException('Saving error.');
        }
        $this->dispatcher->dispatchAll($entity->releaseEvents());
    }

    public function remove(Payment $entity)
    {
        if (!$entity->delete()) {
            throw new \RuntimeException('Removing error.');
        }
    }
}