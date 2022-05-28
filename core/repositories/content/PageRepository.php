<?php

namespace core\repositories\content;

use core\entities\content\Page;
use core\repositories\exceptions\NotFoundException;

class PageRepository
{
    /**
     * @param $slug
     * @return Page
     */
    public function get($slug)
    {
        if (!$entity = Page::findOne($slug)) {
            throw new NotFoundException('Page is not found.');
        }
        return $entity;
    }

    public function save(Page $entity)
    {
        if (!$entity->save()) {
            throw new \RuntimeException('Saving error.');
        }
    }

    public function remove(Page $entity)
    {
        if (!$entity->delete()) {
            throw new \RuntimeException('Removing error.');
        }
    }
}