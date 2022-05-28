<?php

namespace core\readModels;

use core\entities\order\Order;

class OrderReadRepository
{
    public static function create()
    {
        return new static();
    }

    public function get($id)
    {
        return Order::findOne($id);
    }

    public function getByCode($code)
    {
        return Order::findOne(['code' => $code]);
    }

    public function getOwn($userId)
    {
        return Order::find()->where(['user_id' => $userId]);
    }

    public function getToProviderPurchase($status)
    {
        if (!in_array($status, [Order::STATUS_PENDING, Order::STATUS_ERROR])) {
            throw new \DomainException("Not allowed status");
        }

        return Order::find()->where(['status' => $status]);
    }

    public function countNotDelivered()
    {
        return $this->countError() + $this->countSuspend();
    }

    public function countError()
    {
        return Order::find()->where(['status' => Order::STATUS_ERROR])->count();
    }

    public function countSuspend()
    {
        return Order::find()->where(['status' => Order::STATUS_SUSPENDED])->count();
    }


}