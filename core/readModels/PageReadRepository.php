<?php

namespace core\readModels;

use core\entities\content\Page;

class PageReadRepository
{
    public function get($slug)
    {
        return Page::findOne(['slug' => $slug]);
    }
}