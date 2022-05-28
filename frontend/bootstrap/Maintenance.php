<?php

namespace frontend\bootstrap;


use core\settings\storage\MainSettings;
use yii\base\BootstrapInterface;
use yii\web\ForbiddenHttpException;

class Maintenance implements BootstrapInterface
{
    public function bootstrap($app)
    {
        $container = \Yii::$container;
        $mainSettings = $container->get(MainSettings::class);

        if ($mainSettings->isDisableSite()) {
            $message = $mainSettings->getDisableSiteMessage() ?: "Сайт временно недоступен. Приносим извинения за неудобства";
            throw new ForbiddenHttpException($message);
        }

    }
}