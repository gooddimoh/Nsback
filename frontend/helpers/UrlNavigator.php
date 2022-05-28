<?php

namespace frontend\helpers;

class UrlNavigator
{

    public static function viewProduct($slug): array
    {
        return ['/products/view', 'slug' => $slug];
    }

    public static function viewCategory($slug)
    {
        return ['/category/view', 'slug' => $slug];
    }

    public static function viewGroup($slug)
    {
        return ['/group/view', 'slug' => $slug];
    }

}