<?php

namespace core\lib\leqshop;

class ErrorReader
{
    const MAP = [
        "Ошибка!<br>Указан несуществующий купон" => CouponNotValidException::class,
        "Данный купон не может быть применен к этому заказу" => CouponNotValidException::class,
    ];

    public static function throw($errorMessage)
    {
        foreach (self::MAP as $error => $exception) {
            if ($errorMessage === $error) {
                throw new $exception($errorMessage);
            }
        }

        throw new ApiException($errorMessage);
    }

}