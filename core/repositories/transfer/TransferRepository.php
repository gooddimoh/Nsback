<?php

namespace core\repositories\transfer;

use core\entities\transfer\Transfer;
use core\repositories\exceptions\NotFoundException;

class TransferRepository
{
    public function get($id)
    {
        return $this->getBy(['id' => $id]);
    }

    public function save(Transfer $entity)
    {
        if (!$entity->save()) {
            throw new \RuntimeException('Saving error.');
        }
    }

    public function remove(Transfer $entity)
    {
        if (!$entity->delete()) {
            throw new \RuntimeException('Removing error.');
        }
    }

    /**
     * @param array $condition
     * @return Transfer
     * @throws NotFoundException
     */
    protected function getBy(array $condition)
    {
        if (!$entity = Transfer::findOne($condition)) {
            throw new NotFoundException('Transfer not found.');
        }
        return $entity;
    }

}