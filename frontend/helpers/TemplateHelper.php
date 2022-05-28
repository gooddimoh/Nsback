<?php

namespace frontend\helpers;

class TemplateHelper
{

    public static function disableAds(array &$params)
    {
        $params['template.disableAds'] = true;
    }

    public static function isAdsEnable(array &$params)
    {
        return !isset($params['template.disableAds']) || !$params['template.disableAds'];
    }

}