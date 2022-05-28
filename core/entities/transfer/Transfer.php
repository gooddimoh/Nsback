<?php

namespace core\entities\transfer;

use core\entities\User\User;

/**
 * This is the model class for table "transfer".
 *
 * @property int $id
 * @property int $user_id
 * @property string|null $description
 * @property float $sum
 * @property int $type
 * @property int $date
 *
 * @property User $user
 */

// TODO: from/source - admin/system
class Transfer extends \yii\db\ActiveRecord
{
    const TYPE_INCOME = 10;
    const TYPE_EXPENSE = 20;

    public static function make($userId, $description, $sum, $type)
    {
        $entity = new static();
        $entity->user_id = $userId;
        $entity->description = $description;
        $entity->sum = $sum;
        $entity->type = $type;
        $entity->date = time();

        return $entity;
    }

    public static function tableName()
    {
        return 'transfer';
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'Пользователь',
            'description' => 'Описание',
            'sum' => 'Сумма',
            'type' => 'Тип',
            'date' => 'Дата',
        ];
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
