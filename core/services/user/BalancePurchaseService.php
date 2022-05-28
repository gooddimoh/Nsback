<?php

namespace core\services\user;

use core\repositories\Order\OrderRepository;
use core\repositories\Order\PaymentRepository;
use core\repositories\UserRepository;
use core\services\payment\PaymentService;
use core\services\TransactionManager;
use core\services\transfer\TransferService;

class BalancePurchaseService
{
    private $users;
    private $payments;
    private $paymentService;
    private $transactionManager;
    private $transferService;

    public function __construct(
        PaymentService     $paymentService,
        PaymentRepository  $payments,
        TransactionManager $transactionManager,
        UserRepository     $users,
        TransferService    $transactionService,
        OrderRepository    $orders
    )
    {
        $this->paymentService = $paymentService;
        $this->payments = $payments;
        $this->transactionManager = $transactionManager;
        $this->users = $users;
        $this->transferService = $transactionService;
        $this->orders = $orders;
    }

    public function paid($paymentId, $userId)
    {
        $payment = $this->payments->get($paymentId);
        $user = $this->users->get($userId);

        $user->withdrawBalance($payment->sum);

        $this->transactionManager->execute(function () use ($user, $payment) {
            $this->users->save($user);
            $this->transferService->addExpense($user->id, "Оплата платежа №{$payment->id}", $payment->getSum());
            $this->paymentService->paidByReplenish($payment->id, $payment->getSum());
        });
    }

}