<?php

namespace core\lib\markup;

class MarkupManager
{
    public static function calculateMarkupWithSum($sum, $percent, $roundSum = false)
    {
        $resultSum = self::calculateMarkup($sum, $percent) + $sum;
        return $roundSum ? self::roundSum($resultSum) : $resultSum;
    }

    public static function roundSum($sum)
    {
        if ($sum < 1) {
            return round($sum, 2);
        }
        if ($sum > 1 && $sum < 2) {
            return round($sum, 1);
        }

        return round($sum, 2);
    }
    

    public static function calculateMarkup($sum, $percent)
    {
        if (is_numeric($sum) && $sum > 0 && is_numeric($percent) && $percent > 0) {
            return $sum * $percent / 100;
        }

        return 0;
    }
}