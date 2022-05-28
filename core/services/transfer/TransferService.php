<?php

namespace core\services\transfer;

use core\entities\transfer\Transfer;
use core\repositories\transfer\TransferRepository;

class TransferService
{
    private $transfers;

    public function __construct(TransferRepository $repository)
    {
        $this->transfers = $repository;
    }

    public function addIncome($userId, $description, $sum)
    {
        $transaction = Transfer::make($userId, $description, $sum, Transfer::TYPE_INCOME);
        $this->transfers->save($transaction);
    }

    public function addExpense($userId, $description, $sum)
    {
        $transaction = Transfer::make($userId, $description, $sum, Transfer::TYPE_EXPENSE);
        $this->transfers->save($transaction);
    }

    public function delete($id)
    {
        $entity = $this->transfers->get($id);
        $this->transfers->remove($entity);
    }

}