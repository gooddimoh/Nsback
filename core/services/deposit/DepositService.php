<?php

namespace core\services\deposit;

use core\entities\payment\Payment;
use core\forms\deposit\DepositForm;
use core\lib\payment\PaymentSystemList;
use core\repositories\order\PaymentRepository;
use core\repositories\UserRepository;
use core\services\payment\PaymentService;
use core\services\TransactionManager;
use core\services\transfer\TransferService;
use core\settings\storage\DepositInterface;
use core\settings\storage\PaymentSystemInterface;
use DomainException;

class DepositService
{
    private UserRepository $users;
    private PaymentService $paymentService;
    private PaymentRepository $payments;
    private TransactionManager $transactionManager;
    private TransferService $transferService;

    public function __construct(PaymentService $paymentService, UserRepository $users, PaymentRepository $payments, TransactionManager $transactionManager, TransferService $transferService)
    {
        $this->paymentService = $paymentService;
        $this->users = $users;
        $this->payments = $payments;
        $this->transactionManager = $transactionManager;
        $this->transferService = $transferService;
    }

    public function create(DepositForm $form, $userId)
    {
        $paymentList = new PaymentSystemList();
        /** @var $paymentSystem DepositInterface|PaymentSystemInterface */
        $paymentSystem = $paymentList->createInstance($form->method);

        if (!$paymentSystem instanceof DepositInterface) {
            throw new DomainException("Выбранная система не служит для пополнения баланса");
        }
        if ($paymentSystem->getMinimum() > $form->sum) {
            throw new DomainException("Минимальная сумма: {$paymentSystem->getMinimum()}");
        }
        if ($paymentSystem->getMaximum() < $form->sum) {
            throw new DomainException("Максимальная сумма: {$paymentSystem->getMaximum()}");
        }

        $user = $this->users->get($userId);
        $payment = Payment::makeForDeposit($form->sum, $form->method, $user);

        $this->transactionManager->execute(function () use ($payment) {
            $this->payments->save($payment);
        });

        return $this->paymentService->createPaymentUrlForDeposit($payment);
    }

    public function confirm($id)
    {
        $payment = $this->payments->get($id);

        if (!$payment->isTypeDeposit()) {
            throw new \LogicException("The payment should have a deposit type");
        }

        $user = $this->users->get($payment->paymentDeposit->user_id);
        $user->addBalance($payment->getSum());

        $this->transactionManager->execute(function () use ($user, $payment) {
            $this->users->save($user);
            $this->transferService->addIncome($user->getId(), "Депозит через платеж №{$payment->getId()}", $payment->getSum());
        });

    }

}