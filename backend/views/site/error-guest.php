<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

$this->context->layout = 'main-login';
$this->title = $name;
?>

<div class="login-box">
    <div class="login-logo">
        <a href="#"><b>Admin</b>Panel</a>
    </div>
    <div class="login-box-body">
        <p class="login-box-msg"><?= $name ?></p>
        <p>
            <?= nl2br(Html::encode($message)) ?>
        </p>

    </div>
</div>
