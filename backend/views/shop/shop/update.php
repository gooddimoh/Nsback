<?php

/* @var $this yii\web\View */
/* @var $model \core\forms\shop\ShopForm */
/* @var $shop \core\entities\shop\Shop */

$this->title = 'Редактирование магазина: ' . $shop->name;
$this->params['breadcrumbs'][] = ['label' => 'Магазины', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $shop->name, 'url' => ['view', 'id' => $shop->id]];
$this->params['breadcrumbs'][] = 'Редактировать';
\backend\helpers\TemplateHelper::boxWrap($this->params);
?>
<div>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
