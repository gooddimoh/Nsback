<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var $model \core\forms\shop\LeqshopForm
 * @var $this \yii\web\View
 */

$this->title = "Leqshop";
$this->params['breadcrumbs'][] = ['label' => 'Настройки Leqshop', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\backend\helpers\TemplateHelper::boxWrap($this->params);
?>

<div>
    <?php $form = ActiveForm::begin() ?>

    <?= $form->field($model, 'domain') ?>

    <?= $form->field($model, 'apiKeyPublic') ?>

    <?= $form->field($model, 'apiKeyPrivate')->passwordInput() ?>

    <?= $form->field($model, 'productKey')->passwordInput() ?>

    <?= $form->field($model, 'createOrderKey')->passwordInput() ?>

    <h3>Платежный аккаунт</h3>
    <div class="row">

        <div class="col-md-6"><?= $form->field($model, 'userEmail')->textInput() ?></div>
        <div class="col-md-6"><?= $form->field($model, 'userToken')->passwordInput() ?></div>
    </div>


    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end() ?>
</div>
