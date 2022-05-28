<?php

namespace core\helpers;

use Yii;

class SettingsHelper
{

    public static function getSiteUrl()
    {
        $params = self::getParams();

        return "{$params['domain.protocol']}://{$params['domain.value']}";
    }

    protected static function getParams()
    {
        return Yii::$app->params;
    }

}