<?php

namespace core\entities\mail;

use yii\db\ActiveRecord;

/***
 * @property int $id
 * @property int $uni_email_id
 * @property string $email
 * @property string|null $status
 * @property int $date
 */
class Mail extends ActiveRecord
{
    public static function create($uniEmailId, $email)
    {
        $entity = new static();
        $entity->uni_email_id = $uniEmailId;
        $entity->email = $email;
        $entity->status = null;
        $entity->date = time();
        $entity->save(false);

        return $entity;
    }

    public static function tableName()
    {
        return "mail";
    }

    public function updateStatus($status)
    {
        $this->status = $status;
        $this->save(false);
    }

}