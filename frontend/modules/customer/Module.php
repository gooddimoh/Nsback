<?php

namespace frontend\modules\customer;

use Yii;
use yii\filters\AccessControl;
use yii\web\View;

/**
 * customer module definition class
 */
class Module extends \yii\base\Module
{

    public $controllerNamespace = 'frontend\modules\customer\controllers';

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'except' => [
                    'auth/auth/login', 'auth/signup/request', 'auth/reset/request', 'auth/reset/confirm',
                    'auth/verification/confirm',
                ],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function init()
    {
        parent::init();

        Yii::$app->setComponents([
            'view' => [
                'class' => View::class,
                'assetBundles' => [
                    'bootstrap' => Yii::$app->assetManager->getBundle(\yii\bootstrap\BootstrapAsset::class)
                ]
            ]
        ]);

    }

}
