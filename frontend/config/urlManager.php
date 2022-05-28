<?php

/** @var array $params */

return [
    'class' => 'yii\web\UrlManager',
    'baseUrl' => '',
    'enablePrettyUrl' => true,
    'showScriptName' => false,
    'hostInfo' => "{$params['domain.protocol']}://{$params['domain.value']}",
    'rules' => [
        '' => 'site/index',
        'products/view/<slug:[a-z0-9_\-]+>' => '/products/view',
        'category/view/<slug:[a-z0-9_\-]+>' => '/category/view',
        'group/view/<slug:[a-z0-9_\-]+>' => '/group/view',
        'product/info/<slug:[a-z0-9._\-]+>' => '/product/info',
        'page/faq' => '/page/faq',
        'page/agreement' => '/page/agreement',
        'page/<slug:[a-z0-9._\-]+>' => '/page/view',
        'categories' => '/category/index',
        ['pattern' => 'sitemap', 'route' => 'sitemap/default/index', 'suffix' => '.xml'],
    ],
];