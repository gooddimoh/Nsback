<?php

/** @var array $params */

return [
    'class' => 'yii\web\UrlManager',
    'enablePrettyUrl' => true,
    'showScriptName' => false,
    'baseUrl' => "{$params['domain.protocol']}://{$params['domain.value']}/backend/web",
    'rules' => [],
];
