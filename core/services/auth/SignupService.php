<?php

namespace core\services\auth;

use core\entities\user\User;
use core\forms\auth\SignupForm;
use core\repositories\UserRepository;

class SignupService
{
    private $users;

    public function __construct(UserRepository $users)
    {
        $this->users = $users;
    }

    public function signup(SignupForm $form, $ip)
    {
        $user = User::requestSignup(
            $form->username,
            $form->email,
            $form->password,
            $ip
        );
        $this->users->add($user);

        return $user;
    }
}