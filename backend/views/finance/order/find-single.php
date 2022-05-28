<?php

use backend\forms\order\OrderFindSingleForm;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;


/* @var $this View */
/* @var $model OrderFindSingleForm */
/* @var $form yii\widgets\ActiveForm */

$this->title = "Найти заказ";
\backend\helpers\TemplateHelper::boxWrap($this->params);
?>

<p>
    Код можно извлечь из ссылки на заказ.
    <code>https://<?= Yii::$app->params['domain.value'] ?>/order/result?code=<b>07d84797d9751d3842b039338f975a332daef26979eb7ade56f90bde8773cdf9</b>&email=weneedposts%40gmail.com</code><br>
</p>

<div>
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'code')->textInput(['placeholder' => '858bdbbad92e98b40ee3428b712abcdd2c8e731e91c9b04762b7295b823a6a7e']) ?>

    <div class="form-group">
        <?= Html::submitButton('Искать', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
