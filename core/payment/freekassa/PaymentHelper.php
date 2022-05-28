<?php

namespace core\payment\freekassa;

class PaymentHelper
{
    public static function renameLabelsByAliases(&$data, $aliasList)
    {
        foreach ($aliasList as $paramName => $alias) {
            foreach ($data as $key => $value) {
                if($paramName === $key) {
                    $data[$alias] = $value;
                    unset($data[$key]);
                }
            }
        }
    }

}