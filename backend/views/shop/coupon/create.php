<?php

use core\forms\shop\CouponForm;
use yii\web\View;

/**
 * @var $this View
 * @var $model CouponForm
 */

$this->title = 'Новый купон';
$this->params['breadcrumbs'][] = ['label' => 'Купоны', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
