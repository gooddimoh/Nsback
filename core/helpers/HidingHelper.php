<?php


namespace core\helpers;


class HidingHelper
{

    public static function generateKey($additionalData = null)
    {
        return hash("sha256", time() . uniqid('', true . $additionalData));
    }

}