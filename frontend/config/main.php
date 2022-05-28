<?php

use yii\log\FileTarget;

$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => [
        'log',
        \common\bootstrap\SetUp::class,
        \frontend\bootstrap\SetUp::class,
        \frontend\bootstrap\Maintenance::class,
    ],
    'modules' => [
        'point' => [
            'class' => frontend\modules\point\Module::class,
        ],
        'customer' => [
            'class' => frontend\modules\customer\Module::class,
        ],
        'sitemap' => [
            'class' => 'himiklab\sitemap\Sitemap',
            'models' => [
                \core\entities\product\Category::class,
                \core\entities\product\Group::class,
                \core\entities\product\Product::class,
                \core\entities\content\Page::class,
            ],
            'urls' => require __DIR__ . '/sitemapUrls.php',
            'cacheExpire' => 43200,
        ],
    ],
    'language' => 'ru-RU',
    'controllerNamespace' => 'frontend\controllers',
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-frontend',
            'baseUrl' => '',
        ],
        'user' => [
            'identityClass' => \core\entities\user\User::class,
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
            'loginUrl' => ['/customer/auth/auth/login'],
        ],
        'session' => [
            'name' => 'advanced-frontend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => FileTarget::class,
                    'levels' => ['error', 'warning'],
                ],
                [
                    'class' => FileTarget::class,
                    'categories' => ['mailing'],
                    'logFile' => '@runtime/logs/mailing.log',
                    'logVars' => [],
                    'maxFileSize' => 5120,
                ],
                [
                    'class' => FileTarget::class,
                    'categories' => ['checkReadiness'],
                    'logFile' => '@runtime/logs/check-readiness.log',
                    'logVars' => [],
                    'maxFileSize' => 10240,
                ],
                [
                    'class' => FileTarget::class,
                    'categories' => ['buyError'],
                    'logFile' => '@runtime/logs/buy-error.log',
                    'logVars' => [],
                    'maxFileSize' => 10240,
                ],
                [
                    'class' => FileTarget::class,
                    'categories' => ['qiwiInvoice', 'qiwiInvoiceError'],
                    'logFile' => '@runtime/logs/qiwiInvoice.log',
                    'logVars' => [],
                    'maxFileSize' => 40240,
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'backendUrlManager' => require __DIR__ . '/../../backend/config/urlManager.php',
        'frontendUrlManager' => require __DIR__ . '/urlManager.php',
        'urlManager' => function () {
            return Yii::$app->get('frontendUrlManager');
        },
    ],

    'params' => $params,
];
