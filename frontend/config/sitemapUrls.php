<?php

use himiklab\sitemap\behaviors\SitemapBehavior;

return [

    ['loc' => '/products/catalog', 'changefreq' => SitemapBehavior::CHANGEFREQ_WEEKLY, 'priority' => 0.8],
    ['loc' => '/order/history', 'changefreq' => SitemapBehavior::CHANGEFREQ_WEEKLY, 'priority' => 0.6],
];