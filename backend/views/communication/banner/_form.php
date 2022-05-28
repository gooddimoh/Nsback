<?php

use core\forms\communication\BannerForm;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use core\helpers\communication\BannerHelper;

/**
 * @var $this yii\web\View
 * @var $form yii\widgets\ActiveForm
 * @var $model BannerForm
 */

$js = <<<JS
const targetUrl = document.getElementById("target-url");
const imageUrl = document.getElementById("image-url");
const demo = document.getElementById("demo");

showBanner(targetUrl.value, imageUrl.value);
imageUrl.addEventListener("change", () => showBanner(targetUrl.value, imageUrl.value))
targetUrl.addEventListener("change", () => showBanner(targetUrl.value, imageUrl.value))

function showBanner(url, imageUrl)
{
    if(url) {
        demo.innerHTML = "";
        demo.append(banner(url, imageUrl));
    }
}

function banner(url, imageUrl)
{
    let image = document.createElement("img");
    image.src = imageUrl;
    
    let hyperlink = document.createElement("a");
    hyperlink.target = "_blank";
    hyperlink.href = url;
    hyperlink.append(image)
    
    return hyperlink;
}

JS;

$this->registerJs($js, \yii\web\View::POS_END);
?>

<div class="banner">
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput() ?>

    <?= $form->field($model, 'target_url')->textInput(['id' => 'target-url']) ?>

    <?= $form->field($model, 'image_url')->textInput(['id' => 'image-url']) ?>

    <pre id="demo"></pre>

    <?= $form->field($model, 'location')->dropDownList(BannerHelper::locationList()) ?>

    <?= $form->field($model, 'is_active')->checkbox() ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
