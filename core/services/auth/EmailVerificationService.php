<?php

namespace core\services\auth;

use core\lib\unisender\RenderMail;
use core\lib\unisender\UnisenderWrapper;
use core\repositories\UserRepository;
use Yii;

class EmailVerificationService
{
    private $unisenderWrapper;
    private $users;

    public function __construct(UserRepository $users, UnisenderWrapper $unisenderWrapper)
    {
        $this->unisenderWrapper = $unisenderWrapper;
        $this->users = $users;
    }

    public function request($id)
    {
        $user = $this->users->get($id);

        if (!$user->isActive()) {
            throw new \DomainException('Профиль деактивирован.');
        }

        $user->requestVerifyEmail();
        $this->users->save($user);

        $this->unisenderWrapper->sendEmail(
            $user->email,
            'Подтверждение e-mail | ' . Yii::$app->name,
            RenderMail::render("auth/verification/confirm-html", ['user' => $user])
        );

        $sent = $this->unisenderWrapper->sendEmail(
            $user->email,
            'Подтверждение e-mail | ' . Yii::$app->name,
            RenderMail::render("auth/verification/confirm-html", ['user' => $user])
        );

        if (!$sent) {
            throw new \RuntimeException('Ошибка отправки.');
        }
    }

    public function confirm($token)
    {
        if (empty($token) || !is_string($token)) {
            throw new \DomainException('Токен подтверждения e-mail не может быть пустым.');
        }
        if (!$this->users->existByVerficationToken($token)) {
            throw new \DomainException('Неверный токен подтверждения e-mail.');
        }

        $user = $this->users->getByVerificationToken($token);
        $user->moveEmailToVerified();
        $this->users->save($user);
    }

}