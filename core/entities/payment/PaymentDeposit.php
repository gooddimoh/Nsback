<?php

namespace core\entities\payment;

use core\entities\user\User;
use yii\db\ActiveRecord;

/**
 * @property int $user_id
 * @property int $payment_id
 *
 * @property User $user
 * @property Payment $payment
 */
class PaymentDeposit extends ActiveRecord
{
    public static function make(User $user, Payment $payment)
    {
        $entity = new static();
        $entity->populateRelation('user', $user);
        $entity->populateRelation('payment', $payment);

        return $entity;
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            $related = $this->getRelatedRecords();
            /** @var User $user */
            if (isset($related['user']) && $user = $related['user']) {
                if (empty($user->id)) {
                    $user->save();
                }
                $this->user_id = $user->id;
            }
            /** @var Payment $payment */
            if (isset($related['payment']) && $payment = $related['payment']) {
                if (empty($payment->id)) {
                    $payment->save();
                }
                $this->payment_id = $payment->id;
            }
            return true;
        }
        return false;
    }


    public static function tableName()
    {
        return "payment_deposit";
    }

    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    public function getPayment()
    {
        return $this->hasOne(Payment::class, ['id' => 'payment_id']);
    }

}