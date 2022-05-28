<?php

namespace core\lib\unisender\logger;

class DummyLoggerMail extends LoggerMail
{

    function fail($error)
    {
        \Yii::error($error, "unisenderError");
    }
}