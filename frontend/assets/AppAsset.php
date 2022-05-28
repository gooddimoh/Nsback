<?php

namespace frontend\assets;

use yii\web\AssetBundle;
use yii\web\YiiAsset;
use yii\bootstrap\BootstrapAsset;

/**
 * Main application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/style.css?v=20',
        'https://cdn.jsdelivr.net/npm/sweetalert2@10.10.1/dist/sweetalert2.min.css',
        'css/jquery.fancybox.min.css',
    ];
    public $js = [
        'https://cdn.jsdelivr.net/npm/sweetalert2@10.10.1/dist/sweetalert2.all.js',
        'js/components/floatfly.js?v=2',
        'js/components/yandex-commerce.js',
        'js/main.js?v=17',
        'js/components/search-selected-filter-counter.js',
        "js/components/move-to-search-result.js?v=15",
        'js/external/jquery.fancybox.min.js',
        'js/components/save-user-data.js?v=7',
    ];
    public $depends = [
        YiiAsset::class,
    ];
}
