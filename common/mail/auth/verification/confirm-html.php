<?php

use core\entities\user\User;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user User */

$verificationLink = Yii::$app->urlManager->createAbsoluteUrl(['/customer/auth/verification/confirm', 'token' => $user->email_verification_token]);
?>
<div class="email-verification">
    <p>Здравствуйте, <?= Html::encode($user->username) ?>,</p>

    <p>Пройдите по ссылке чтобы привязать данный e-mail к аккаунту магазина:</p>

    <p><?= Html::a(Html::encode($verificationLink), $verificationLink) ?></p>
</div>
