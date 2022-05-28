<?php

use yii\helpers\Html;

?>

<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">Меню</h3>
    </div>
    <div class="box-body">
        <ul class="nav nav-pills nav-stacked">
            <li role="presentation"><?= Html::a('Основные настройки', ['main']) ?></li>
            <li role="presentation"><?= Html::a('Payeer', ['payeer']) ?></li>
            <li role="presentation"><?= Html::a('Lava', ['lava']) ?></li>
            <li role="presentation"><?= Html::a('Freekassa', ['freekassa']) ?></li>
            <li role="presentation"><?= Html::a('Enot', ['enot']) ?></li>
            <li role="presentation"><?= Html::a('Coinbase', ['coinbase']) ?></li>
        </ul>
    </div>
</div>