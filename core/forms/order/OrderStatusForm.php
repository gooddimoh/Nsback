<?php

namespace core\forms\order;

use core\entities\order\Order;
use yii\base\Model;
use core\helpers\order\OrderHelper;

class OrderStatusForm extends Model
{
    public $status;

    public function __construct(Order $order, $config = [])
    {
        parent::__construct($config);
        $this->status = $order->status;
    }

    public function rules()
    {
        return [
            [['status'], 'required'],
            [['status'], 'in', 'range' => Order::ALLOW_MANAGER_SET_STATUS],
        ];
    }

    public function attributeLabels()
    {
        return [
            'status' => 'Статус'
        ];
    }

    public static function getStatusList()
    {
        $list = [];

        foreach (Order::ALLOW_MANAGER_SET_STATUS as $status) {
            $list[$status] = OrderHelper::statusName($status);
        }

        return $list;
    }

}