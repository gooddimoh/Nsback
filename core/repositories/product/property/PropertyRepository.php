<?php

namespace core\repositories\product\property;

use core\entities\product\property\Property;
use core\repositories\exceptions\NotFoundException;

class PropertyRepository
{
    /**
     * @param $id
     * @return Property
     */
    public function find($id)
    {
        if (!$model = Property::findOne($id)) {
            throw new NotFoundException('Model not found.');
        }
        return $model;
    }

    public function save(Property $model)
    {
        if ($model->save(false) === false) {
            throw new \RuntimeException('Saving error.');
        }
    }

    public function delete(Property $model)
    {
        if (!$model->delete()) {
            throw new \RuntimeException('Deleting error.');
        }
    }


}