<?php

namespace core\repositories\product\property;

use core\entities\product\property\PropertyCategory;
use core\repositories\exceptions\NotFoundException;

class PropertyCategoryRepository
{
    /**
     * @param $id
     */
    public function find($id)
    {
        if (!$model = PropertyCategory::findOne($id)) {
            throw new NotFoundException('Model not found.');
        }
        return $model;
    }

    public function save(PropertyCategory $model)
    {
        if ($model->save(false) === false) {
            throw new \RuntimeException('Saving error.');
        }
    }

    public function delete(PropertyCategory $model)
    {
        if (!$model->delete()) {
            throw new \RuntimeException('Deleting error.');
        }
    }


}