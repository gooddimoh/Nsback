<?php

/* @var $this \yii\web\View */

/* @var $content string */

use core\entities\communication\Banner;
use core\settings\storage\MainSettings;
use frontend\helpers\TemplateHelper;
use frontend\widgets\BannerWidget;
use yii\helpers\Html;
use frontend\assets\AppAsset;
use common\widgets\Alert;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;

AppAsset::register($this);
$mainSettings = Yii::$container->get(MainSettings::class);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="referrer" content="origin"/>

    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>

    <?= $mainSettings->getHeadCode() ?>
    <?php echo $this->render("metrics") ?>

    <?php $this->head() ?>
</head>
<body id="body">
<?php $this->beginBody() ?>

<?= Alert::widget() ?>
<?= $content ?>

<?php $this->endBody() ?>
<?= $mainSettings->getEndBodyCode() ?>
</body>
</html>
<?php $this->endPage() ?>
