<?php

/* @var $this \yii\web\View */
/* @var $user \core\entities\user\User */

use frontend\assets\BootstrapForce;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = "Синхронизировать заказы";
BootstrapForce::register($this);
?>

<div>
    <h2><?= $this->title ?></h2>
    <p>
        Если Вы делали заказы без регистрации - мы можем подтянуть их
        в <?= Html::a("историю заказов", ['/customer/order/history'], ['class' => 'button-doted']) ?> с помощью регистрационного e-mail.
    </p>

    <?php if ($user->isEmailVerified()): ?>
        <p>
            <?= Html::a("Синхронизировать", Url::current(), [
                'class' => 'btn btn-lg btn-success btn-color-white',
                'data' => ['method' => 'POST'],
            ]) ?>
        </p>
    <?php else: ?>
    <div class="well">
        <p>
            В целях безопасности, нам необходимо убедиться что регистрационный e-mail принадлежит Вам.<br>
            Мы отправим письмо для подтверждения.
        </p>
        <p>
            <?= Html::a("Подтвердить", ['/customer/auth/verification/request'], ['class' => 'btn btn-info']) ?>
        </p>
    </div>
    <?php endif; ?>
</div>