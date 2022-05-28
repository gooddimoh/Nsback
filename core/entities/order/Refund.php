<?php

namespace core\entities\order;

use core\entities\EventTrait;
use core\entities\order\events\OrderRefundEvent;
use yii\db\ActiveRecord;

/***
 * @property int $id
 * @property int $order_id
 * @property string|null $bill
 * @property int $refund_to_balance
 * @property string|null $comment
 * @property int $type
 * @property float $sum
 * @property int $quantity
 * @property int $created_at
 *
 * @property Order $order
 */
class Refund extends ActiveRecord
{
    use EventTrait;

    const TYPE_CANCEL = 10;
    const TYPE_PARTIAL = 20;

    public static function make(Order $order, $comment, $quantity, $bill = null, $refundToBalance = false)
    {
        if (!$refundToBalance && !$bill) {
            throw new \DomainException("Specify the bill");
        }
        if ($quantity > $order->quantity) {
            throw new \DomainException("Refund quantity bigger Order quantity");
        }
        if (!$order->isCanBeRefundable()) {
            throw new \DomainException("Order has uncancelled status");
        }

        $entity = new static();
        $entity->order_id = $order->id;
        $entity->comment = $comment;
        $entity->quantity = $quantity;
        $entity->bill = $refundToBalance ? $order->user_id : $bill;
        $entity->refund_to_balance = $refundToBalance;
        $entity->type = self::calculateCancelType($quantity, $order->quantity);
        $entity->sum = self::calculateRefundSum($order->calculateCostPerOne(), $quantity);
        $entity->created_at = time();

        $entity->recordEvent(new OrderRefundEvent($entity));

        return $entity;
    }

    public function isRefundToBalance()
    {
        return $this->refund_to_balance;
    }

    protected static function calculateRefundSum($pricePerOne, $quantity)
    {
        return $pricePerOne * $quantity;
    }

    protected static function calculateCancelType($quantity, $orderQuantity)
    {
        return $orderQuantity === intval($quantity) ? self::TYPE_CANCEL : self::TYPE_PARTIAL;
    }

    public static function tableName()
    {
        return 'order_refund';
    }

    public function attributeLabels()
    {
        return [
            'bill' => 'Счёт',
            'refund_to_balance' => 'Возврат на баланс',
            'order_id' => 'Заказ',
            'comment' => 'Комментарий',
            'type' => 'Тип',
            'sum' => 'Сумма',
            'quantity' => 'Количество',
            'created_at' => 'Дата создания',
        ];
    }

    public function getOrder()
    {
        return $this->hasOne(Order::class, ['id' => 'order_id']);
    }


}