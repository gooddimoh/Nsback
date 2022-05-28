<?php

use backend\helpers\TemplateHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this \yii\web\View */
/* @var $model \core\forms\user\BalanceOperationForm */
/* @var $user \core\entities\user\User */

$this->title = "Добавить баланс: {$user->getEncodedUsername()}";
$this->params['breadcrumbs'][] = ['label' => 'Пользователи', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $user->username, 'url' => ['view', 'id' => $user->id]];
$this->params['breadcrumbs'][] = $this->title;
TemplateHelper::boxWrap($this->params);
?>

<div class="col-md-4">
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'sum')->textInput(['placeholder' => 250]) ?>

    <?= $form->field($model, 'reason')->textInput(['placeholder' => 'Пополнение баланса']) ?>

    <div class="form-group">
        <?= Html::submitButton('Отправить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
<div class="col-md-8">
    <p>
        <br>
        <b class="text-warning">Предупреждение:</b> Не используйте форму для возврата средств за заказ. <br>
        Для этой цели воспользуйтесь кнопкой "Возврат" на странице заказа.
    </p>
    <p><?= Html::img("@imgDoc/do-not-use-add-balance-for-refund.png", ['class' => 'img-responsive img-thumbnail']) ?></p>
</div>

