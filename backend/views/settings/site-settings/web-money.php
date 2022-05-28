<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var $model \core\forms\settings\WebMoneySettingsForm
 * @var $this \yii\web\View
 */

$this->title = "WebMoney";
?>

<div class="col-md-2">
    <?= $this->render('_payment-menu') ?>
</div>
<div class="col-md-10">
    <div class="box">
        <div class="box-body">
            <p>
                Обязательно <b>активируйте опцию</b> "Позволять использовать URL, передаваемые в форме" в
                <a href="https://merchant.webmoney.ru/conf/purses.asp">настройках кошелька</a>.
            </p>

            <?php $form = ActiveForm::begin() ?>

            <div class="row">
                <div class="col-md-6"><?= $form->field($model, 'rWallet') ?></div>
                <div class="col-md-6"><?= $form->field($model, 'rKey')->passwordInput() ?></div>
            </div>

            <?= $form->field($model, 'description')->textarea() ?>

            <?= $form->field($model, 'disable')->checkbox() ?>

            <div class="form-group">
                <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
            </div>

            <?php ActiveForm::end() ?>
        </div>
    </div>
</div>
