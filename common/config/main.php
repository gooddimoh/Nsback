<?php

use yii\caching\FileCache;

return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => FileCache::class,
            'cachePath' => '@common/runtime/cache',
        ],
        'settings' => [
            'class' => 'yii2mod\settings\components\Settings',
        ],
        'i18n' => [
            'translations' => [
                'yii2mod.settings' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@yii2mod/settings/messages',
                ],
            ],
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
            'cache' => 'cache',
        ],

        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => \yii\log\FileTarget::class,
                    'categories' => ['djekxa', 'djekxaEmpty', 'djekxaEmptyClient'],
                    'logFile' => '@common/runtime/logs/djekxa.log',
                    'logVars' => [],
                    'maxFileSize' => 12500,
                ],
            ],
        ],

    ],
];
