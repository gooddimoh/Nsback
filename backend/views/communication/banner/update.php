<?php

use core\entities\communication\Banner;
use core\forms\communication\BannerForm;

/**
 * @var $banner Banner
 * @var $this yii\web\View
 * @var $model BannerForm
 */

$this->title = 'Редактирование баннера: ' . $banner->name;
$this->params['breadcrumbs'][] = ['label' => 'Баннеры', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $banner->name, 'url' => ['view', 'id' => $banner->id]];
$this->params['breadcrumbs'][] = 'Редактировать';
?>
<div>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
