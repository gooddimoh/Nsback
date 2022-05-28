<?php

namespace core\helpers\communication;

use core\entities\communication\Banner;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

class BannerHelper
{

    public static function locationList()
    {
        return [
            Banner::LOCATION_TOP => "Верх сайта",
            Banner::LOCATION_BOTTOM => "Низ сайта",
        ];
    }

    public static function locationName($location)
    {
        return ArrayHelper::getValue(self::locationList(), $location);
    }

    public static function activationLabel($isActive)
    {
        return Html::tag("span", $isActive ? "Активно" : "Неактивно", [
            'class' => $isActive ? "label label-success" : "label label-danger",
        ]);
    }

}