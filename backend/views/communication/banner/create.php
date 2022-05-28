<?php

use core\forms\communication\BannerForm;
use yii\web\View;

/**
 * @var $this View
 * @var $model BannerForm
 */

$this->title = 'Новый баннер';
$this->params['breadcrumbs'][] = ['label' => 'Баннеры', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
