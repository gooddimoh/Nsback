<?php

use backend\helpers\GroupList;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\web\View;
use core\forms\import\ImportForm;

/**
 * @var $model ImportForm
 * @var $this View
 */

$this->title = 'Новый импорт';
\backend\helpers\TemplateHelper::boxWrap($this->params);
?>

<div>
    <?php $form = ActiveForm::begin() ?>

    <?= $form->field($model, 'shopId')->dropDownList(ImportForm::getShopList()) ?>

    <?= $form->field($model, 'groupId')->dropDownList(GroupList::get()) ?>

    <?= $form->field($model, 'shouldModerate')->checkbox() ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end() ?>
</div>