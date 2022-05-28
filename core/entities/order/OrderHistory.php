<?php

namespace core\entities\order;

use core\helpers\HidingHelper;
use Yii;

/**
 * This is the model class for table "order_history".
 *
 * @property int $id
 * @property string $hash
 * @property string $email
 * @property int $created_at
 */
class OrderHistory extends \yii\db\ActiveRecord
{
    public static function make($email)
    {
        $entity = new static();
        $entity->hash = HidingHelper::generateKey($email);
        $entity->email = $email;
        $entity->created_at = time();

        return $entity;
    }

    public static function tableName()
    {
        return 'order_history';
    }


    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'hash' => 'Hash',
            'email' => 'Email',
            'created_at' => 'Created At',
        ];
    }
}
