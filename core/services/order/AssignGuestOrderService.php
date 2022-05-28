<?php

namespace core\services\order;

use core\forms\order\OrderAssignForm;
use core\repositories\exceptions\NotFoundException;
use core\repositories\order\OrderRepository;
use core\repositories\UserRepository;

class AssignGuestOrderService
{
    private $users;
    private $orders;

    public function __construct(UserRepository $users, OrderRepository $orders)
    {
        $this->orders = $orders;
        $this->users = $users;
    }

    public function assignAll($userId)
    {
        $user = $this->users->get($userId);
        $i = 0;

        if (!$user->isEmailVerified()) {
            throw new \DomainException("Данная функция доступна только для пользователей с верифицированным e-mail");
        }

        foreach ($this->orders->getAllGuestOrderByEmail($user->email) as $order) {
            $order->assignUser($user->getId());
            $this->orders->save($order);

            $i++;
        }

        return $i;
    }

    public function assignByForm(OrderAssignForm $form)
    {
        $user = $this->users->get($form->userId);

        try {
            $order = $this->orders->getByCodeAndEmail($form->code, $form->email);
            $order->assignUser($user->getId());
            $this->orders->save($order);
        } catch (NotFoundException $exception) {
            throw new \DomainException("Заказ с указанным кодом и e-mail не найден");
        }
    }

}