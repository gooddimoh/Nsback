<?php

use backend\helpers\TemplateHelper;
use vova07\imperavi\Widget;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\web\View;
use core\forms\product\ProductBulkUpdateForm;

/**
 * @var $model ProductBulkUpdateForm
 * @var $this View
 * @var $ids array
 * @var $rulesTemplates array
 */

$this->title = 'Массовое редактирование';
TemplateHelper::boxWrap($this->params);
?>

<p>
    Массовое редактирование для товаров под номерами:
</p>
<div class="well">
    <?= rtrim(implode(",", $ids), ",") ?>
</div>
<div>
    <?php $form = ActiveForm::begin() ?>

    <?= $form->field($model, 'group')->dropDownList(ProductBulkUpdateForm::getGroupList(), ['prompt' => '']) ?>


    <?= $form->field($model, 'rules')->widget(Widget::class, [
        'settings' => [
            'lang' => 'ru',
            'minHeight' => 200,
            'plugins' => [
                'fullscreen',
                'clips',
            ],
            'clips' => $rulesTemplates,
        ],
    ]) ?>

    <?= $form->field($model, 'miniature')->fileInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end() ?>

</div>