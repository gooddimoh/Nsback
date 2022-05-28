<?php

namespace core\helpers;

use Yii;

class TokenTimer
{
    public static function isTokenNotExpire($token, $expire): bool
    {
        $timestamp = (int)substr($token, strrpos($token, '_') + 1);

        return $timestamp + $expire >= time();
    }

    public static function generateToken(): string
    {
        return Yii::$app->security->generateRandomString() . '_' . time();
    }

}