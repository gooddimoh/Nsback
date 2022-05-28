<?php

namespace common\rbac;


class Roles
{
    const ROLE_ADMINISTRATOR = 'administrator';
    const ROLE_SENIOR_MANAGER = 'seniorManager';
    const ROLE_SUPPORT = 'support';

    const PERMISSION_MANAGER_PANEL = 'managerPanel';

    public static function hasRole($roleName, $userId)
    {
        $userRoles = \Yii::$app->authManager->getRolesByUser($userId);

        foreach ($userRoles as $userRole) {
            if ($userRole->name == $roleName) {
                return true;
            }
        }

        return false;
    }

    public static function hasPermission($permissionName, $userId)
    {
        $permissions = \Yii::$app->authManager->getPermissionsByUser($userId);

        foreach ($permissions as $permission) {
            if ($permission->name == $permissionName) {
                return true;
            }
        }

        return false;

    }

}