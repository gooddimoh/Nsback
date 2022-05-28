<?php

/* @var $this \yii\web\View */

/* @var $user User */

use core\entities\user\User;
use yii\bootstrap\BootstrapAsset;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = "Подтвердить e-mail";
BootstrapAsset::register($this);
?>

<div>
    <h2><?= $this->title ?></h2>
    <p>
        Пожалуйста, подтвердите Ваш e-mail чтобы иметь доступ к дополнительным функциям сервиса, например -
        <?= Html::a("синхронизация гостевых заказов", ['order/sync-email'], ['class' => 'button-doted']) ?>.
        <br>
        Если необходимо сменить e-mail - обратитесь в поддержку.
    </p>
    <p>
        Регистрационный e-mail: <code><?= $user->email ?></code><br>
        Верифицирован:
        <span class="text-<?= $user->isEmailVerified() ? "success" : "danger" ?>">
            <?= Yii::$app->formatter->asBoolean($user->isEmailVerified()) ?>
        </span>
    </p>


    <?php if (!$user->isEmailVerified()): ?>
        <div class="form-group">
            <?= Html::a("Подтвердить", Url::current(), [
                'class' => 'btn btn-lg btn-info',
                'data' => ['method' => "POST"],
            ]) ?>
        </div>
    <?php endif; ?>

</div>