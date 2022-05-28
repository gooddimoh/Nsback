<?php

namespace frontend\assets;

class BootstrapAsset extends \yii\bootstrap\BootstrapAsset
{
    public $depends = [
        BootstrapForce::class
    ];
}