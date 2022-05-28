<?php

use yii\filters\AccessControl;
use yii\log\FileTarget;
use core\entities\user\User;

$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'language' => 'ru-RU',
    'bootstrap' => [
        \common\bootstrap\SetUp::class,
        'log',
    ],
    'aliases' => [
        '@jsView' => 'backend/web/js/views',
        '@imgDoc' => '/backend/web/img/doc'
    ],
    'modules' => [],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-backend',
        ],
        'user' => [
            'identityClass' => User::class,
            'enableAutoLogin' => true,
            'identityCookie' => [
                'name' => '_identity-backend',
                'httpOnly' => true,
            ],
            'loginUrl' => ['/auth/login'],
        ],
        'session' => [
            'name' => 'advanced-backend',
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
                    'categories' => ['managerDoAction'],
                    'logFile' => '@runtime/logs/managerDoAction.log',
                    'logVars' => [],
                    'maxFileSize' => 30720,
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'backendUrlManager' => require __DIR__ . '/urlManager.php',
        'frontendUrlManager' => require __DIR__ . '/../../frontend/config/urlManager.php',
        'urlManager' => function () {
            return Yii::$app->get('backendUrlManager');
        },
    ],
    'as access' => [
        'class' => AccessControl::class,
        'except' => ['auth/login', 'auth/verification', 'auth/verification-resend', 'site/error'],
        'rules' => [
            [
                'allow' => true,
                'roles' => [\common\rbac\Roles::PERMISSION_MANAGER_PANEL],
            ],
        ],
    ],
    'on beforeAction' => function (\yii\base\ActionEvent $event) {
        if (Yii::$app->request->isPost) {
            $request = Yii::$app->request;
            Yii::info([
                'user' => !Yii::$app->user->isGuest ? Yii::$app->user->identity->username : "Guest",
                'url' => $event->action->getUniqueId(),
                'body' => $request->getBodyParams(),
                'params' => $request->getQueryParams(),
                'ip' => $request->userIP,
            ], "managerDoAction");
        }
    },
    'params' => $params,
];
