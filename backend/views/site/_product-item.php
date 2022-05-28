<?php

use yii\helpers\Url;
use yii\helpers\StringHelper;

/**
 * @var $model \core\entities\product\Product
 */

?>

<li class="item">
    <div class="product-img">
        <img src="<?= $model->getMiniature() ?>" alt="Product Image">
    </div>
    <div class="product-info">
        <a href="<?= Url::to(['/product/product/view', 'id' => $model->id]) ?>" class="product-title">
            <?= $model->name ?>
            <span class="label label-info pull-right">
                <?= $model->price ?><i class="fa fa-rub" aria-hidden="true"></i>
            </span></a>
        <span class="product-description">
            <?= strip_tags(StringHelper::truncate($model->description, 255)) ?>
        </span>
    </div>
</li>
