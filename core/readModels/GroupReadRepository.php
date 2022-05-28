<?php

namespace core\readModels;

use core\entities\product\Category;
use core\entities\product\Group;

class GroupReadRepository
{
    public function getForMainPage($categoryId = null, $groupId = null)
    {
        $query = Group::find()->joinWith("category")
            ->andFilterWhere([Group::tableName() . ".id" => $groupId, Category::tableName() . ".id" => $categoryId])
            ->orderBy([
                Category::tableName() . '.position' => SORT_ASC,
                Group::tableName() . '.position' => SORT_ASC,
            ]);

        if (empty($categoryId) && empty($groupId)) {
            $query->limit(40);
        }

        return $query->all();
    }

    public function getByCategory($id)
    {
        return Group::find()->where(['category_id' => $id]);
    }

    public function get($slug)
    {
        return Group::findOne(['slug' => $slug]);
    }

}
