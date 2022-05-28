<?php

use rmrevin\yii\fontawesome\FontAwesome;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this \yii\web\View */
/* @var $model \core\forms\order\OrderAssignForm */
/* @var $order \core\entities\order\Order */

$this->title = "Привязать заказ №{$order->getId()}";
$this->params['breadcrumbs'][] = ['label' => 'Заказы', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => "№{$order->getId()}", 'url' => ['view', 'id' => $order->getId()]];
$this->params['breadcrumbs'][] = 'Привязать заказ';
\backend\helpers\TemplateHelper::boxWrap($this->params);
?>

<div>
    <p>
        Чтобы привязать заказ без подтверждения по e-mail - попросите пользователя выслать:
    </p>
    <ol>
        <li>Логин или E-mail аккаунта, чтобы <?= Html::a("найти ID", ['user/index'], ['target' => '_blank'])?> пользователя</li>
        <li>E-mail, который указывался при <u>создании заказа</u></li>
        <li>
            Ссылку на заказ. Из неё необходимо извлечь код. Пример:<br>
            <code>https://<?= Yii::$app->params['domain.value'] ?>/order/result?code=<b>dd3b88229749161e1ed5eb30b6dfb301</b>&email=marko%40gmail.com</code><br>
        </li>
    </ol>
    <p>
        <?= FontAwesome::icon("warning", ['class' => 'text-warning']) ?> Перечисленные данные необходимо получить от пользователя.
        Это поможет убедиться, что именно данный пользователь - владелец заказа.
    </p>

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'userId')->textInput(['placeholder' => '5']) ?>
    <?= $form->field($model, 'email')->textInput(['placeholder' => 'marko@gmail.com']) ?>
    <?= $form->field($model, 'code')->textInput(['placeholder' => 'dd3b88229749161e1ed5eb30b6dfb301']) ?>

    <div class="form-group">
        <?= Html::submitButton('Привязать', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
