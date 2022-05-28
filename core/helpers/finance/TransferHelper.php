<?php

namespace core\helpers\finance;

use core\entities\transfer\Transfer;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

class TransferHelper
{
    public static function typeList()
    {
        return [
            Transfer::TYPE_INCOME => 'Приход',
            Transfer::TYPE_EXPENSE => 'Расход',
        ];
    }

    public static function typeNameHighlighted($type)
    {
        switch ($type) {
            case Transfer::TYPE_INCOME:
                $class = "text-success";
                break;
            case Transfer::TYPE_EXPENSE: {
                $class = "text-danger";
                break;
            }
            default: $class = "text-muted";
        }

        return Html::tag("span", self::typeName($type), ['class' => $class]);
    }

    public static function typeName($type)
    {
        return ArrayHelper::getValue(self::typeList(), $type);
    }

}