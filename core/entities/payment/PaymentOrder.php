<?php

namespace core\entities\payment;

use core\entities\order\Order;
use yii\db\ActiveRecord;

/**
 * @property int $order_id
 * @property int $payment_id
 *
 * @property Order $order
 * @property Payment $payment
 */
class PaymentOrder extends ActiveRecord
{
    public static function make(Order $order, Payment $payment)
    {
        $entity = new static();
        $entity->populateRelation('order', $order);
        $entity->populateRelation('payment', $payment);

        return $entity;
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            $related = $this->getRelatedRecords();
            /** @var Order $order */
            if (isset($related['order']) && $order = $related['order']) {
                if (empty($order->id)) {
                    $order->save();
                }
                $this->order_id = $order->id;
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
        return "payment_order";
    }

    public function getOrder()
    {
        return $this->hasOne(Order::class, ['id' => 'order_id']);
    }

    public function getPayment()
    {
        return $this->hasOne(Payment::class, ['id' => 'payment_id']);
    }

}