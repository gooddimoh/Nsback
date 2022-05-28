<?php


/* @var $product Product */
/* @var $this View */

/* @var $model UrlForm */

use core\entities\product\Product;
use core\forms\product\UrlForm;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;

$this->title = "Редактировать URL {$product->name}";
\backend\helpers\TemplateHelper::boxWrap($this->params);
?>

<div>
    <p>
        <b class="text-warning">Меняйте ссылку только в крайнем случае!</b> После изменения старая ссылка окажется недоступной,
        и мы потеряем посетителей, которые переходят по ней из поисковых систем, или других источников.
        <?= Html::a("Почему так?", ['/help/do-not-change-url'], ['target' => '_blank']) ?>
    </p>
</div>
<div>
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'slug') ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>

