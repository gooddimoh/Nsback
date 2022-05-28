<?php

namespace core\helpers\product;

use core\entities\shop\Shop;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

class ShopHelper
{
    public static function statusList()
    {
        return [
            Shop::STATUS_ACTIVE => 'Активен',
            Shop::STATUS_BLOCKED => 'Заблокирован',
        ];
    }

    public static function statusName($value)
    {
        return ArrayHelper::getValue(self::statusList(), $value);
    }

    public static function statusLabel($status)
    {
        switch ($status) {
            case Shop::STATUS_ACTIVE:
                $class = "success";
                break;
            case Shop::STATUS_BLOCKED: {
                $class = "danger";
                break;
            }
            default: $class = "text-muted";
        }

        return Html::tag("span", self::statusName($status), ['class' => "label label-$class"]);
    }

    public static function platformList()
    {
        return [
            Shop::PLATFORM_DJEKXA => 'Djekxa',
            Shop::PLATFORM_LEQSHOP => 'Leqshop',
            Shop::PLATFORM_RAPTOR => 'Raptor (Test Environment)',
        ];
    }

    public static function platformName($platform)
    {
        return ArrayHelper::getValue(self::platformList(), $platform);
    }

}