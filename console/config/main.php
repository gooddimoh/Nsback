<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-console',
    'name' => 'Console',
    'basePath' => dirname(__DIR__),
    'bootstrap' => [
        'log',
        \common\bootstrap\SetUp::class,
    ],
    'controllerNamespace' => 'console\controllers',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'controllerMap' => [
        'fixture' => [
            'class' => 'yii\console\controllers\FixtureController',
            'namespace' => 'common\fixtures',
          ],
    ],
    'components' => [
        'log' => [
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
                [
                    'class' => 'yii\log\FileTarget',
                    'categories' => ['media'],
                    'logFile' => '@runtime/logs/media.log',
                    'logVars' => [],
                    'maxFileSize' => 10720,
                ],
                [
                    'class' => 'yii\log\FileTarget',
                    'categories' => ['purchase'],
                    'logFile' => '@runtime/logs/purchase.log',
                    'logVars' => [],
                    'maxFileSize' => 30720,
                ],
            ],
        ],
        'backendUrlManager' => require __DIR__ . '/../../backend/config/urlManager.php',
        'frontendUrlManager' => require __DIR__ . '/../../frontend/config/urlManager.php',
        'urlManager' => [
            'baseUrl' => "{$params['domain.protocol']}://{$params['domain.value']}",
        ],
    ],
    'params' => $params,
];
