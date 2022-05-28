<?php

namespace core\helpers\order;

use core\entities\order\Refund;
use yii\helpers\ArrayHelper;

class RefundHelper
{

    public static function typeList()
    {
        return [
            Refund::TYPE_CANCEL => "Полный возврат",
            Refund::TYPE_PARTIAL => "Частичный возврат",
        ];
    }

    public static function typeName($status)
    {
        return ArrayHelper::getValue(self::typeList(), $status);
    }

    public static function methodName($isRefundToBalance)
    {
        return $isRefundToBalance ? "Баланс магазина" : "Реквизиты";
    }

}