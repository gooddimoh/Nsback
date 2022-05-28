<?php

/* @var $this yii\web\View */
/* @var $user \core\entities\user\User */

$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['/customer/auth/reset/confirm', 'token' => $user->password_reset_token]);
?>
Здравствуйте, <?= $user->username ?>,

Проследуйте по ссылке для сброса пароля:

<?= $resetLink ?>
