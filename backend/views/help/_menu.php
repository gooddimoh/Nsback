<?php

use yii\helpers\Html;

?>

<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">Меню</h3>
    </div>
    <div class="box-body">
        <ul class="nav nav-pills nav-stacked">
            <li role="presentation"><?= Html::a('Основное', ['index']) ?></li>
            <li role="presentation"><?= Html::a('Заказы', ['order']) ?></li>
            <li role="presentation"><?= Html::a('Платежи', ['payment']) ?></li>
            <li role="presentation"><?= Html::a('Товары', ['product']) ?></li>
            <li role="presentation"><?= Html::a('Почему нельзя часто менять ссылку на товар?', ['do-not-change-url']) ?></li>
        </ul>
    </div>
</div>
