<?php

namespace core\services\auth\verify;

use core\entities\user\VerificationAuth;
use core\repositories\UserRepository;
use core\repositories\VerificationAuthRepository;

class VerificationAuthService
{
    private VerificationAuthRepository $records;
    private VerifySenderInterface $sender;
    private UserRepository $users;

    public function __construct(VerificationAuthRepository $records, UserRepository $users, VerifySenderInterface $sender)
    {
        $this->records = $records;
        $this->sender = $sender;
        $this->users = $users;
    }

    public function add($userId, $addressee, $ip)
    {
        $verificationAuth = VerificationAuth::make($userId, $addressee, $ip);

        if ($verificationAuth->isHourVerificationTriesLimitReached($this->records->countLastTriesByIp($ip))) {
            throw new \DomainException("Превышен лимит попыток авторизации. Попробуйте через 15 минут.");
        }

        $this->records->save($verificationAuth);
        $this->sender->send($addressee, $verificationAuth->verify_code);

        return $verificationAuth;
    }

    public function resend($hash)
    {
        $verificationAuth = $this->records->get($hash);

        if ($verificationAuth->isConfirmed()) {
            throw new \DomainException("Авторизация по данному коду уже прошла");
        }
        if (!$verificationAuth->isResendHoldExpired()) {
            throw new \DomainException("Разрешена отправка 1-го уведомления в минуту");
        }

        $verificationAuth->resend();
        $this->records->save($verificationAuth);

        $this->sender->send($verificationAuth->addressee, $verificationAuth->verify_code);
    }

    public function verify($hash, $code)
    {
        $verificationAuth = $this->records->get($hash);

        if ($verificationAuth->isConfirmed()) {
            throw new \DomainException("Авторизация по данному коду уже прошла");
        }
        if ($verificationAuth->isExpired()) {
            throw new \DomainException("Данный код просрочен. Попробуйте авторизоваться ещё раз.");
        }
        if ($verificationAuth->isAttemptsLimitReached()) {
            throw new \DomainException("Достигнут лимит неверных вводов. Авторизуйтесь заново.");
        }
        if (!$verificationAuth->isVerifyCodeEquivalentTo($code)) {
            $verificationAuth->addAttempt();
            $this->records->save($verificationAuth);

            throw new \DomainException("Введён неверный код. Осталось попыток: {$verificationAuth->countRemainAttempts()}");
        }

        $verificationAuth->confirm();
        $this->records->save($verificationAuth);

        return $this->users->get($verificationAuth->user_id);
    }

}