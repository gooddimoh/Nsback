<?php

namespace frontend\modules\point;

use Yii;
use yii\web\Request;
use yii\web\JsonParser;
use yii\web\Response;
use yii\web\JsonResponseFormatter;

/**
 * point module definition class
 */
class Module extends \yii\base\Module
{

    public $controllerNamespace = 'frontend\modules\point\controllers';

    public function init()
    {
        parent::init();
        Yii::$app->setComponents([
            'request' => [
                'class' => Request::class,
                'parsers' => [
                    'application/json' => JsonParser::class,
                ],
                'enableCookieValidation' => false,
                'enableCsrfValidation' => false,
            ],
            'response' => [
                'class' => Response::class,
                'on beforeSend' => function ($event) {
                    $response = $event->sender;
                    if ($response->data !== null) {
                        $response->data = [
                            'success' => $response->isSuccessful,
                            'data' => $response->data,
                        ];
                        $response->statusCode = 200;
                    }
                },
                'format' => "json",
                'formatters' => [
                    'json' => [
                        'class' => JsonResponseFormatter::class,
                        'prettyPrint' => YII_DEBUG,
                        'encodeOptions' => JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE,
                    ],
                ],
            ],
        ]);
    }
}
