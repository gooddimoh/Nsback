<?php

namespace core\repositories\product;

use core\entities\product\Group;
use core\lib\slug\SluggableRepository;
use core\repositories\exceptions\NotFoundException;
use phpDocumentor\Reflection\DocBlock\Tags\Param;

class GroupRepository implements SluggableRepository
{
    /**
     * @param $id
     * @return Group
     */
    public function get($id)
    {
        return $this->getBy(['id' => $id]);
    }

    public function slugExist($handledSlug)
    {
        return Group::find()->where(['slug' => $handledSlug])->exists();
    }

    public function save(Group $entity)
    {
        if (!$entity->save()) {
            throw new \RuntimeException('Saving error.');
        }
    }

    public function remove(Group $entity)
    {
        if (!$entity->delete()) {
            throw new \RuntimeException('Removing error.');
        }
    }

    protected function getBy(array $condition)
    {
        if (!$entity = Group::findOne($condition)) {
            throw new NotFoundException('Group is not found.');
        }
        return $entity;
    }

}