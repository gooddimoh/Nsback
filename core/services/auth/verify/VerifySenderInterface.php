<?php

namespace core\services\auth\verify;

interface VerifySenderInterface
{

    public function send($addressee, $verifyCode);

}