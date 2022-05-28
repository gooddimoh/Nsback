<?php

use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $content string */
?>

<header class="main-header">

    <?= Html::a('<span class="logo-mini">DG</span><span class="logo-lg">' . Yii::$app->name . '</span>', Yii::$app->homeUrl, ['class' => 'logo']) ?>

    <nav class="navbar navbar-static-top" role="navigation">

        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>

        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <li>
                    <?= Html::a('Справка', ['/help/index'], ['class' => 'btn btn-flat']) ?>
                </li>
                <?php if (Yii::$app->user->can(\common\rbac\Roles::ROLE_ADMINISTRATOR)): ?>
                    <li>
                        <?= Html::a('Настройки', ['/settings/site-settings/index'], ['class' => 'btn btn-flat']) ?>
                    </li>
                <?php endif; ?>
                <li>
                    <?= Html::a(
                        'Выход',
                        ['/auth/logout'],
                        ['data-method' => 'post', 'class' => 'btn btn-flat']
                    ) ?>
                </li>
            </ul>
        </div>
    </nav>
</header>
