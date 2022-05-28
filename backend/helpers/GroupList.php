<?php

namespace backend\helpers;

use core\entities\product\Category;

class GroupList
{

    public static function get()
    {
        $list = [];

        /** @var $category Category */
        foreach (Category::find()->each() as $category) {
            foreach ($category->groups as $group) {
                $list[$category->name][$group->id] = $group->name;
            }
        }

        return $list;
    }

}