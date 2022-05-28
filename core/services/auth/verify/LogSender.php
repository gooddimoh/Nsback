<?php

namespace core\services\auth\verify;

use Yii;

class LogSender implements VerifySenderInterface
{

    public function send($addressee, $verifyCode)
    {
        Yii::info($addressee, "VerifySender_addressee");
        Yii::info($verifyCode, "VerifySender_verifyCode");
    }
}