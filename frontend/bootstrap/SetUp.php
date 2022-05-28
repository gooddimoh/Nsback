<?php

namespace frontend\bootstrap;

use yii\base\BootstrapInterface;
use yii\bootstrap\BootstrapAsset;
use yii\di\Container;


class SetUp implements BootstrapInterface
{
    public function bootstrap($app)
    {
        $container = \Yii::$container;

        $container->set(BootstrapAsset::class, function (Container $container) {
            return $container->get(\frontend\assets\BootstrapAsset::class);
        });
    }
}