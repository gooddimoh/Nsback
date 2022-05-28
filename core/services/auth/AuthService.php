<?php

namespace core\services\auth;


use common\rbac\Roles;
use core\entities\user\User;
use core\forms\auth\LoginForm;
use core\repositories\UserRepository;

class AuthService
{
    private $users;

    public function __construct(UserRepository $users)
    {
        $this->users = $users;
    }

    public function auth(LoginForm $form)
    {
        /**
         * @var $user User
         */
        $user = $this->users->findByUsernameOrEmail($form->username);
        if (!$user || !$user->isActive() || !$user->validatePassword($form->password)) {
            throw new \DomainException('Неверный логин или пароль.');
        }
        return $user;
    }

    public function authAsAdmin(LoginForm $form)
    {
        $user = $this->auth($form);

        if (!Roles::hasPermission(Roles::PERMISSION_MANAGER_PANEL, $user->id)) {
            throw new \DomainException('Недостаточно прав для авторизации');
        }

        return $user;
    }

}