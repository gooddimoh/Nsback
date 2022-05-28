<?php

use core\entities\shop\Coupon;
use core\forms\shop\CouponForm;

/**
 * @var $coupon Coupon
 * @var $this yii\web\View
 * @var $model CouponForm
 */

$this->title = "Купон №{$coupon->id} от магазина {$coupon->shop->name}";
$this->params['breadcrumbs'][] = ['label' => 'Купоны', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => ['view', 'id' => $coupon->id]];
$this->params['breadcrumbs'][] = 'Редактировать';
?>
<div>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
