<?php

namespace core\helpers\order;

use core\entities\order\PromoCode;
use yii\helpers\ArrayHelper;

class PromoCodeHelper
{
    public static function statusList()
    {
        return [
            PromoCode::STATUS_ACTIVE => 'Активен',
            PromoCode::STATUS_INACTIVE => 'Неактивен',
        ];
    }

    public static function statusName($status)
    {
        return ArrayHelper::getValue(self::statusList(), $status);
    }

    public static function hideParts($code, $hideSymbol = '*', $showSymbolCount = 4)
    {
        $length = strlen($code) - $showSymbolCount;
        $mask = $hideSymbol;

        for ($i = 1; $i < $length; $i++) {
            $mask .= $hideSymbol;
        }

        return substr_replace($code, $mask, 1, $length);
    }
}