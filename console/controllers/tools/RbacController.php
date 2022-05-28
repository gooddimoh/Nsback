<?php

namespace console\controllers\tools;

use common\rbac\Roles;
use core\entities\user\User;
use Yii;
use yii\console\Exception;
use yii\helpers\ArrayHelper;
use yii\console\Controller;
use yii\rbac\Role;

class RbacController extends Controller
{

    public function actionInit()
    {
        $auth = Yii::$app->getAuthManager();
        $auth->removeAll();

        $managerRoles = [
            Roles::ROLE_ADMINISTRATOR => 'Управляющий',
            Roles::ROLE_SENIOR_MANAGER => 'Старший менеджер',
            Roles::ROLE_SUPPORT => 'Поддержка',
        ];

        $managerPanelPermission = $auth->createPermission(Roles::PERMISSION_MANAGER_PANEL);
        $managerPanelPermission->description = 'Manager Panel';
        $auth->add($managerPanelPermission);

        foreach ($managerRoles as $key => $name) {
            $managerRole = $auth->createRole($key);
            $managerRole->description = $name;
            $auth->add($managerRole);
            $auth->addChild($managerRole, $managerPanelPermission);
        }

        $this->stdout('Done!' . PHP_EOL);
    }

    public function actionCreatePermission()
    {
        $auth = Yii::$app->getAuthManager();

        $name = $this->prompt('Name:', ['required' => true]);
        $permission = $auth->createPermission($name);
        $auth->add($permission);

        do {
            $list = ArrayHelper::map(array_filter(Yii::$app->authManager->getRoles(), function (Role $role) use ($auth, $permission) {
                return !$auth->hasChild($role, $permission);
            }), 'name', 'description');

            $roleName = $this->select('Assign to role:', ArrayHelper::merge($list, ['none' => 'No one']));

            if ($roleName !== "none") {
                $role = $auth->getRole($roleName);
                $auth->addChild($role, $permission);
            }
        } while ($roleName !== "none");

        $this->stdout('Done!' . PHP_EOL);
    }

    public function actionRemovePermission()
    {
        $auth = Yii::$app->getAuthManager();

        $name = $this->prompt('Name:', ['required' => true]);
        $permission = $auth->getPermission($name);
        $auth->remove($permission);

        $this->stdout('Done!' . PHP_EOL);
    }




}