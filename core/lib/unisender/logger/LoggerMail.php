<?php

namespace core\lib\unisender\logger;

use core\entities\mail\Mail;

abstract class LoggerMail
{
    public function success($id, $email)
    {
        Mail::create($id, $email);
    }

    abstract function fail($error);

}