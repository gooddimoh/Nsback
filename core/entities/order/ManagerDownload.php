<?php

namespace core\entities\order;

use yii\db\ActiveRecord;

/***
 * @property $id
 * @property $order_id
 * @property $user_id
 * @property $download_at
 */

class ManagerDownload extends ActiveRecord
{

    public static function make($orderId, $userId)
    {
        $entity = new static();
        $entity->order_id = $orderId;
        $entity->user_id = $userId;
        $entity->download_at = time();

        return $entity;
    }

    public static function tableName()
    {
        return "manager_download";
    }

}