<?php

use vova07\imperavi\Widget;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use core\forms\product\ProductForm;

/* @var $this yii\web\View */
/* @var $model ProductForm */
/* @var $form yii\widgets\ActiveForm */
/* @var $rulesTemplates array */

$canEditUrl = !$model->getProduct() || $model->getProduct()->isRecentlyAdded();
?>

<div>
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'groupId')->dropDownList(ProductForm::getGroups()) ?>

    <?= $form->field($model, 'name')->textInput() ?>

    <?= $form->field($model, 'slug')->textInput(['disabled' => !$canEditUrl])
        ->hint($canEditUrl ? null : "Редактирование ссылки происходит через " . Html::a("отдельную форму", ['url', 'id' => $model->getProduct()->getId()])) ?>

    <?= $form->field($model, 'description')->widget(Widget::class, [
        'settings' => [
            'lang' => 'ru',
            'minHeight' => 200,
            'plugins' => [
                'fullscreen',
                'fontcolor',
                'table',
            ],
        ],
    ]) ?>

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

    <?= $form->field($model, 'price')->textInput() ?>

    <div class="row">
        <div class="col-md-6"><?= $form->field($model, 'minimumOrder')->textInput() ?></div>
        <div class="col-md-6"><?= $form->field($model, 'quantity')->textInput() ?></div>
    </div>

    <?= $form->field($model, 'miniature')->fileInput() ?>

    <?php foreach ($model::getPropertyCategoryList() as $category):?>
        <p>
            <b><?= $category->name ?></b>
        </p>
        <?php foreach ($category->properties as $property): ?>
            <?= $form->field($model, 'properties[]', ['options' => ['tag' => 'div', 'class' => 'inline-block']])
                ->checkbox([
                    'value' => $property->id,
                    'label' => $property->name,
                    'uncheck' => null,
                    'checked' => $model->isPropertyExists($property->id),
                ]) ?>
        <?php endforeach; ?>
    <?php endforeach; ?>


    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
