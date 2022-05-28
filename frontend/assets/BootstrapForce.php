<?php

namespace frontend\assets;

use yii\bootstrap\BootstrapAsset;
use yii\web\AssetBundle;

/**
 * Некоторые стили шаблона переопределяют стиль Bootstrap по-умолчанию, делая дизайн менее привлекательным.
 * Данный набор создан для вспомогательных стилей, чтобы устранить проблему.
 */
class BootstrapForce extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/bootstrap-force.css',
    ];

    public $depends = [
    ];
}