<?php

namespace core\services\auth;

use core\entities\user\User;
use core\forms\auth\PasswordResetRequestForm;
use core\forms\auth\ResetPasswordForm;
use core\lib\unisender\RenderMail;
use core\lib\unisender\UnisenderWrapper;
use core\repositories\UserRepository;
use Yii;

class PasswordResetService
{
    private $users;
    private UnisenderWrapper $unisender;

    public function __construct(UserRepository $users, UnisenderWrapper $unisender)
    {
        $this->users = $users;
        $this->unisender = $unisender;
    }

    public function request(PasswordResetRequestForm $form)
    {
        $user = $this->users->getByEmail($form->email);

        if (!$user->isActive()) {
            throw new \DomainException('Профиль деактивирован.');
        }

        $user->requestPasswordReset();
        $this->users->save($user);

        $sent = $this->unisender->sendEmail(
            $user->email,
            'Сброс пароля | ' . Yii::$app->name,
            RenderMail::render("auth/reset/confirm-html", ['user' => $user])
        );

        if (!$sent) {
            throw new \RuntimeException('Ошибка отправки.');
        }
    }

    public function validateToken($token)
    {
        if (empty($token) || !is_string($token)) {
            throw new \DomainException('Токен сброса пароля не может быть пустым.');
        }
        if (!$this->users->existsByPasswordResetToken($token)) {
            throw new \DomainException('Неверный токен сброса пароля.');
        }
    }

    public function reset($token, ResetPasswordForm $form)
    {
        /**
         * @var $user User
         */
        $user = $this->users->getByPasswordResetToken($token);
        $user->resetPassword($form->password);
        $this->users->save($user);
    }


}