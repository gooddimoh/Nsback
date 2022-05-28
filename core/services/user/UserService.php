<?php

namespace core\services\user;

use core\forms\user\ChangePassword;
use core\forms\user\UserUpdateForm;
use core\repositories\UserRepository;

class UserService
{
    private $users;

    public function __construct(UserRepository $userRepository)
    {
        $this->users = $userRepository;
    }

    public function changePassword($userId, ChangePassword $form)
    {
        $user = $this->users->get($userId);
        $user->changePassword($form->newPassword);

        $this->users->save($user);
    }

    public function changeApiKey($userId)
    {
        $user = $this->users->get($userId);
        $user->generateApiKey();
        $this->users->save($user);
    }

    public function update($userId, UserUpdateForm $form)
    {
        $user = $this->users->get($userId);
        $user->edit($form->username, $form->email);
        $this->users->save($user);
    }

}