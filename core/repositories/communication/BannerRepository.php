<?php

namespace core\repositories\communication;

use core\entities\communication\Banner;
use core\repositories\exceptions\NotFoundException;

class BannerRepository
{
    /**
     * @param $id
     * @return Banner
     */
    public function get($id)
    {
        if (!$entity = Banner::findOne($id)) {
            throw new NotFoundException('Banner is not found.');
        }
        return $entity;
    }

    public function save(Banner $entity)
    {
        if (!$entity->save()) {
            throw new \RuntimeException('Saving error.');
        }
    }

    public function remove(Banner $entity)
    {
        if (!$entity->delete()) {
            throw new \RuntimeException('Removing error.');
        }
    }

}