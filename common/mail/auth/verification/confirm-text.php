<?php

/* @var $this yii\web\View */
/* @var $user User */

use core\entities\user\User;

$verificationLink = Yii::$app->urlManager->createAbsoluteUrl(['/customer/auth/verification/confirm', 'token' => $user->email_verification_token]);
?>
Здравствуйте, <?= $user->username ?>,

Пройдите по ссылке чтобы привязать данный e-mail к аккаунту магазина:
<?= $verificationLink ?>
