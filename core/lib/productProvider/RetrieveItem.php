<?php

namespace core\lib\productProvider;


class RetrieveItem
{

    public static function retrieve(array $items, $searchColumnKey, $searchValue)
    {
        foreach ($items as $item) {
            if ($item[$searchColumnKey] == $searchValue) {
                return $item;
            }
        }

        return  false;
    }


}