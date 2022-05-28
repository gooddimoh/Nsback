<?php

namespace core\repositories\product;

use core\entities\product\Category;
use core\lib\slug\SluggableRepository;
use core\repositories\exceptions\NotFoundException;

class CategoryRepository implements SluggableRepository
{
    /**
     * @param $id
     * @return Category
     */
    public function get($id)
    {
        if (!$entity = Category::findOne($id)) {
            throw new NotFoundException('Category is not found.');
        }
        return $entity;
    }

    public function slugExist($slug)
    {
        return Category::find()->where(['slug' => $slug])->exists();
    }

    public function save(Category $entity)
    {
        if (!$entity->save()) {
            throw new \RuntimeException('Saving error.');
        }
    }

    public function remove(Category $entity)
    {
        if (!$entity->delete()) {
            throw new \RuntimeException('Removing error.');
        }
    }
}