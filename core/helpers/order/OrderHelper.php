<?php

namespace core\helpers\order;

use core\entities\product\Product;
use core\entities\order\Order;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\VarDumper;

class OrderHelper
{
    public static function statusList()
    {
        return [
            Order::STATUS_UNPAID => "Не оплачен",
            Order::STATUS_PENDING => "Очередь",
            Order::STATUS_COMPLETED => "Завершен",
            Order::STATUS_ERROR => "Ошибка",
            Order::STATUS_CANCELED => "Отменен",
            Order::STATUS_CANCELED_BY_USER => "Отменен пользователем",
            Order::STATUS_REFUND => "Возврат",
            Order::STATUS_SUSPENDED => "Приостановлен",
            Order::STATUS_PROCESSING => "Обрабатывается",
        ];
    }

    public static function statusName($status)
    {
        return ArrayHelper::getValue(self::statusList(), $status);
    }

    public static function statusLabel($status)
    {
        switch ($status) {
            case Order::STATUS_UNPAID:
                $class = 'label label-default';
                break;
            case Order::STATUS_PENDING:
                $class = 'label label-primary';
                break;
            case Order::STATUS_COMPLETED:
                $class = 'label label-success';
                break;
            case Order::STATUS_ERROR:
                $class = 'label label-danger';
                break;
            case Order::STATUS_SUSPENDED:
                $class = 'label label-info';
                break;
            case Order::STATUS_CANCELED:
            case Order::STATUS_CANCELED_BY_USER:
                $class = 'label label-warning';
                break;
            case Order::STATUS_REFUND: {
                $class = 'label label-warning';
                break;
            }
            default:
                $class = 'label label-default';
        }

        return Html::tag('span', self::statusName($status), [
            'class' => $class,
        ]);
    }

    public static function getOptions($price, $name)
    {
        return json_encode(['name' => $name, 'price' => $price], JSON_HEX_QUOT | JSON_HEX_APOS);
    }

}