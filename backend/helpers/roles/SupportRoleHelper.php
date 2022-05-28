<?php

namespace backend\helpers\roles;

use common\rbac\Roles;
use Yii;

class SupportRoleHelper
{

    public static function isCurrentyIdentitySupport()
    {
        return Roles::hasRole(Roles::ROLE_SUPPORT, Yii::$app->user->id);
    }

    public static function readOnlyMatchCallback()
    {
        return function () {
            Yii::$app->session->setFlash("info", "Вам доступен только просмотр информации, редактирование отключено");
            return true;
        };
    }

}