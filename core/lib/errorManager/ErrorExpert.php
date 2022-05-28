<?php

namespace core\lib\errorManager;

class ErrorExpert
{
    protected const LOW_BALANCE_MESSAGES = [
        "Response not JSON: Fail balance",
        "has not enough balance money",
    ];

    public static function isLowBalanceError($error)
    {
        return in_array($error, self::LOW_BALANCE_MESSAGES);
    }

}