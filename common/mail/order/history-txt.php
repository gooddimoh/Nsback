<?php

use core\entities\order\OrderHistory;

/* @var $this yii\web\View */
/* @var $history OrderHistory */

$historyUrl = Yii::$app->urlManager->createAbsoluteUrl(['/order/history', 'code' => $history->hash]);
?>

Список ваших заказов доступен по ссылке: <?php echo $historyUrl ?>

