<?php

namespace core\lib\telegram\template;

use core\repositories\UserRepository;

class ManagerDownloadLimitReachedTemplate implements MessageTemplate
{
    private $users;

    private $message;

    public function __construct(UserRepository $users)
    {
        $this->users = $users;
    }

    public function createMessage($userId, $quantity)
    {
        $user = $this->users->get($userId);
        $this->message = "$user->username достиг лимита загрузки товара: $quantity";
    }

    public function getMessage()
    {
        return $this->message;
    }

}