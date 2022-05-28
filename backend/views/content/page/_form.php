<?php

use dosamigos\tinymce\TinyMce;
use vova07\imperavi\Widget;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model \core\forms\content\PageForm */
/* @var $form yii\widgets\ActiveForm */
?>

<div>
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput() ?>

    <?= $form->field($model, 'content')->widget(TinyMce::class, [
        'options' => ['rows' => 35],
        'language' => 'ru',
        'clientOptions' => [
            'plugins' => [
                "advlist autolink lists link charmap print preview anchor",
                "searchreplace visualblocks code fullscreen",
                "insertdatetime media table contextmenu paste"
            ],
            'toolbar' => "undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
        ]
    ]);?>

<!--    --><?php //echo  $form->field($model, 'content')->widget(Widget::class, [
//        'settings' => [
//            'lang' => 'ru',
//            'minHeight' => 200,
//            'plugins' => [
//                'fullscreen',
//                'fontcolor',
//                'table',
//            ],
//        ],
//    ])  ?>

    <div class="row">
        <div class="col-md-6"><?= $form->field($model, 'seoDescription')->textarea() ?></div>
        <div class="col-md-6"<?= $form->field($model, 'seoKeywords')->textarea() ?></div>
    </div>
    <div class="clearfix"></div>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
