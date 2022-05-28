<?php

namespace core\helpers\product;

use core\entities\product\Product;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

class ProductHelper
{
    public static function statusList()
    {
        return [
            Product::STATUS_ACTIVE => 'Активен',
            Product::STATUS_HIDDEN => 'Скрыт',
            Product::STATUS_MODERATION => 'Модерация',
            Product::STATUS_DELETED => 'Удален',
            Product::STATUS_TEMPORARY_UNAVAILABLE => 'Временно недоступен',
            Product::STATUS_BLOCKED => 'Заблокирован',
        ];
    }

    public static function statusName($status)
    {
        return ArrayHelper::getValue(self::statusList(), $status);
    }

    public static function statusLabel($status)
    {
        switch ($status) {
            case Product::STATUS_ACTIVE:
                $class = 'label label-primary';
                break;
            case Product::STATUS_HIDDEN:
                $class = 'label label-default';
                break;
            case Product::STATUS_MODERATION:
                $class = 'label label-warning';
                break;
            case Product::STATUS_BLOCKED:
            case Product::STATUS_DELETED:
                $class = 'label label-danger';
                break;
            case Product::STATUS_TEMPORARY_UNAVAILABLE:
                $class = 'label label-info';
                break;
            default:
                $class = 'label label-default';
        }

        return Html::tag('span', self::statusName($status), [
            'class' => $class,
        ]);
    }

    public static function topLabel($isBig = false)
    {
        $big = $isBig ? "account__item-label2_big" : "";
        return Html::tag("span", "TOP", ['class' => "account__item-label2_top $big"]);
    }

}