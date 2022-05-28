<?php

namespace core\readModels;

use core\entities\product\Category;

class CategoryReadRepository
{
    public function get($slug)
    {
        return Category::findOne(['slug' => $slug]);
    }

}