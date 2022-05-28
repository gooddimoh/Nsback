<?php

namespace core\services\user;

use core\forms\user\BalanceOperationForm;
use core\repositories\UserRepository;
use core\services\TransactionManager;
use core\services\transfer\TransferService;

class BalanceService
{
    private $users;
    private $transferService;
    private $transactionManager;

    public function __construct(UserRepository $userRepository, TransferService $transferService, TransactionManager $transactionManager)
    {
        $this->users = $userRepository;
        $this->transferService = $transferService;
        $this->transactionManager = $transactionManager;
    }

    public function addBalance($userId, $sum, $reason)
    {
        $user = $this->users->get($userId);
        $user->addBalance($sum);

        $this->transactionManager->execute(function () use ($reason, $sum, $user) {
            $this->users->save($user);
            $this->transferService->addIncome($user->id, $reason, $sum);
        });
    }

    public function writeOffBalance($userId, $sum, $reason)
    {
        $user = $this->users->get($userId);

        $user->writeOffBalance($sum);

        $this->transactionManager->execute(function () use ($reason, $sum, $user) {
            $this->users->save($user);
            $this->transferService->addExpense($user->id, "Списание администрацией. $reason", $sum);
        });
    }

    public function addBalanceByForm($userId, BalanceOperationForm $form)
    {
        $this->addBalance($userId, $form->sum, "Пополнено администрацией. $form->reason");
    }

    public function writeOffBalanceByForm($userId, BalanceOperationForm $form)
    {
        $this->writeOffBalance($userId, $form->sum, $form->reason);
    }
}