<?php

/**
 * @var $this \yii\web\View
 */

use yii\helpers\Html;

$this->title = 'Настройки';
?>

<p>
    Выберите категорию настроек
</p>

<div class="col-md-3">
    <?= $this->render('_payment-menu') ?>
</div>
<div class="col-md-3">

    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Ваш аккаунт</h3>
        </div>
        <div class="box-body">
            <ul class="nav nav-pills nav-stacked">
                <li role="presentation"><?= Html::a('Смена пароля', ['/user/index']) ?></li>
            </ul>
        </div>
    </div>
</div>

