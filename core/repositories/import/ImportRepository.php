<?php

namespace core\repositories\import;

use core\entities\import\ImportTask;
use core\repositories\exceptions\NotFoundException;

class ImportRepository
{
    /**
     * @param $id
     * @return ImportTask
     */
    public function get($id)
    {
        if (!$entity = ImportTask::findOne($id)) {
            throw new NotFoundException('ImportTask is not found.');
        }
        return $entity;
    }

    public function save(ImportTask $entity)
    {
        if (!$entity->save()) {
            throw new \RuntimeException('Saving error.');
        }
    }

    public function remove(ImportTask $entity)
    {
        if (!$entity->delete()) {
            throw new \RuntimeException('Removing error.');
        }
    }
}