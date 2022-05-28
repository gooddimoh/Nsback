<?php

/**
 * @var $this \yii\web\View
 */

use core\entities\product\Product;
use core\helpers\product\ProductHelper;

$this->title = "Товары";

$statusActive = ProductHelper::statusName(Product::STATUS_ACTIVE);
$statusHidden = ProductHelper::statusName(Product::STATUS_HIDDEN);
$statusModeration = ProductHelper::statusName(Product::STATUS_MODERATION);
$statusDeleted = ProductHelper::statusName(Product::STATUS_DELETED);
$statusTemporaryUnavailable = ProductHelper::statusName(Product::STATUS_TEMPORARY_UNAVAILABLE);
$statusBlocked = ProductHelper::statusName(Product::STATUS_BLOCKED);
?>

<div class="col-md-2">
    <?= $this->render("_menu") ?>
</div>
<div class="col-md-10">
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Товары</h3>
        </div>
        <div class="box-body">
            <h4 class="text-info">Доступные статусы:</h4>
            <ul>
                <li>
                    <b><?= $statusActive ?></b> - отображается пользователям, доступен к покупке.
                </li>
                <li>
                    <b><?= $statusHidden ?></b> - не отображается пользователям. Используйте статус если необходимо временно скрыть товар, а не удалять его полностью.
                </li>
                <li>
                    <b><?= $statusModeration ?></b> - как правило, возникает после импорта. Внесите необходимые изменения в информацию о товаре, после выставьте статус "<?= $statusActive ?>".
                </li>
                <li>
                    <b><?= $statusDeleted ?></b> - товар не отображается пользователям, а также в администраторской панели.
                </li>
                <li>
                    <b><?= $statusTemporaryUnavailable ?></b> - не удалось получить информацию о товаре от поставщика. Товар отображается, доступен к покупке. После получения информации от поставщика - товар станет "<?= $statusActive ?>".
                </li>
                <li>
                    <b><?= $statusBlocked ?></b> - отображается пользователям, но его нельзя купить - он будет якобы не в наличии.
                    Используется на время поиска другого поставщика товара.
            </ul>

        </div>
    </div>
</div>