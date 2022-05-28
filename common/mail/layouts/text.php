<?php

use yii\helpers\Html;

/** @var \yii\web\View $this view component instance */
/** @var \yii\mail\MessageInterface $message the message being composed */
/** @var string $content main view render result */
?>

<?php $this->beginPage() ?>
<?php $this->beginBody() ?>

<?= $content ?>

================================================
От 50 до 100 рублей за отзыв о магазине!
Оставь отзыв о нашем магазине и получи 100₽ на любой
из Ваших кошельков!
------------------------------------------------
Оставить отзыв: https://<?= Yii::$app->params['domain.value'] ?>/page/bonusy-za-otzyv
================================================

Скидочный купон на 5% уже в нашем Telegram-канале
Канал в Telegram (Скидки и акции): <?= Yii::$app->params['content.telegram.channel'] ?>
Поддержка (Написать нам!): <?= Yii::$app->params['content.telegram.support'] ?>
------------------------------------------------
Замена: https://<?= Yii::$app->params['domain.value'] ?>/page/replacement
Товар не выдался: https://<?= Yii::$app->params['domain.value'] ?>/page/item-not-issued
Правила магазина: https://<?= Yii::$app->params['domain.value'] ?>/page/rules
Задать вопрос: https://<?= Yii::$app->params['domain.value'] ?>/page/support

================================================
================================================
Письмо создано автоматически и не требует ответа
Будем рады видеть Вас снова в магазине <?= Yii::$app->params['domain.value'] ?>
================================================
================================================
===================<?= Yii::$app->name ?>====================
================================================
================================================
<?php $this->endBody() ?>
<?php $this->endPage() ?>
