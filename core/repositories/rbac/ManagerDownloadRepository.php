<?php

namespace core\repositories\rbac;

use core\entities\order\ManagerDownload;
use core\repositories\exceptions\NotFoundException;

class ManagerDownloadRepository
{
    /**
     * @param $id
     * @return ManagerDownload
     */
    public function get($id)
    {
        if (!$entity = ManagerDownload::findOne($id)) {
            throw new NotFoundException('Record is not found.');
        }
        return $entity;
    }

    public function countUserDaily($userId)
    {
        return ManagerDownload::find()
            ->where(['user_id' => $userId])
            ->andWhere("FROM_UNIXTIME(`download_at`) >= NOW() - INTERVAL 1 DAY")
            ->groupBy('order_id')
            ->count();
    }

    public function save(ManagerDownload $entity)
    {
        if (!$entity->save()) {
            throw new \RuntimeException('Saving error.');
        }
    }

    public function remove(ManagerDownload $entity)
    {
        if (!$entity->delete()) {
            throw new \RuntimeException('Removing error.');
        }
    }

}