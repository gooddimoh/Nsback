<?php

namespace core\lib\fake;

class Image
{
    private const SOURCE = "https://picsum.photos/";

    public static function get($width = 200)
    {
        $url = self::SOURCE . $width;
        $headers = get_headers($url, 1);

        return $headers['location'] ?? null;
    }

}