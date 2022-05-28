<?php

namespace common\rbac;

use Yii;

class RolesHierarchy
{
    const HIERARCHY = [
        Roles::ROLE_ADMINISTRATOR,
        Roles::ROLE_SENIOR_MANAGER,
        Roles::ROLE_SUPPORT,
    ];

    public static function isUserHigher($userId, $userIdToCompare)
    {
        $authManager = Yii::$app->authManager;

        $userRoles = $authManager->getRolesByUser($userId);
        $comparedRoles = $authManager->getRolesByUser($userIdToCompare);

        if (empty($userRoles)) {
            return false;
        }
        if (empty($comparedRoles)) {
            return true;
        }

        return self::isRoleHigher(array_shift($userRoles)->name, array_shift($comparedRoles)->name);
    }

    public static function isRoleHigher($role, $roleToCompare)
    {
        return array_search($roleToCompare, self::HIERARCHY) > array_search($role, self::HIERARCHY);
    }

}