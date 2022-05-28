<?php

namespace core\helpers\finance;

use core\entities\payment\Payment;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

class PaymentHelper
{
    public static function statusList()
    {
        return [
            Payment::STATUS_UNPAID => 'Неоплачен',
            Payment::STATUS_PAID => 'Оплачен',
            Payment::STATUS_CANCELED => 'Отменен',
        ];
    }

    public static function statusLabel($status)
    {
        switch ($status) {
            case Payment::STATUS_UNPAID:
                $class = 'label label-default';
                break;
            case Payment::STATUS_PAID:
                $class = 'label label-success';
                break;
            case Payment::STATUS_CANCELED:
                $class = 'label label-danger';
                break;
            default:
                $class = 'label label-default';
        }

        return Html::tag('span', self::statusName($status), [
            'class' => $class,
        ]);
    }

    public static function typeList()
    {
        return [
            Payment::TYPE_DEPOSIT => 'Пополнение',
            Payment::TYPE_ORDER => 'Заказ',
        ];
    }

    public static function methodList()
    {
        return [
            Payment::METHOD_MAZE_BANK => 'Maze Bank(Test)',
            Payment::METHOD_QIWI_P2P => 'Qiwi',
            Payment::METHOD_ENOT => 'Enot.io',
            Payment::METHOD_COINBASE => 'Coinbase',
            Payment::METHOD_WEB_MONEY => 'WebMoney',
            Payment::METHOD_FREEKASSA => 'Freekassa',
            Payment::METHOD_BALANCE => 'Баланс',
            Payment::METHOD_QIWI_CARD => 'Банковская карта',
            Payment::METHOD_PAYEER => 'Payeer',
            Payment::METHOD_LAVA => 'Lava',
        ];
    }

    /* Better Solution: use Interface */
    /*
    public static function orderMethodList()
    {
        return self::methodList();
    }

    public static function depositMethodList()
    {
        $notAllowedList = [Payment::METHOD_BALANCE];

        return array_filter(self::methodList(), function ($key) use ($notAllowedList) {
            return !in_array($key, $notAllowedList);
        }, ARRAY_FILTER_USE_KEY);
    }
    */

    public static function methodName($method)
    {
        return ArrayHelper::getValue(self::methodList(), $method);
    }

    public static function typeName($type)
    {
        return ArrayHelper::getValue(self::typeList(), $type);
    }

    public static function statusName($status)
    {
        return ArrayHelper::getValue(self::statusList(), $status);
    }

}