<?php

use common\rbac\RoleMenu;

?>

<aside class="main-sidebar">
    <section class="sidebar">
        <?php
        if (!Yii::$app->user->isGuest) {
            echo dmstr\widgets\Menu::widget([
                    'options' => ['class' => 'sidebar-menu tree', 'data-widget' => 'tree'],
                    'items' => RoleMenu::get(Yii::$app->user->id),
                ]
            );
        }
        ?>

    </section>
</aside>
