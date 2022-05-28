<?php

namespace core\services\order;

use core\entities\order\Order;
use core\entities\payment\Payment;
use core\repositories\order\OrderRepository;
use core\repositories\order\PaymentRepository;
use core\repositories\order\PromoCodeRepository;
use core\services\TransactionManager;

class PromoCodeActivationService
{
    private $promoCodes;
    private $orders;
    private $payments;
    private $transactionManager;

    public function __construct(PromoCodeRepository $promoCodes, OrderRepository $orders, PaymentRepository $payments, TransactionManager $transactionManager)
    {
        $this->promoCodes = $promoCodes;
        $this->orders = $orders;
        $this->payments = $payments;
        $this->transactionManager = $transactionManager;
    }


    public function use($code, Order $order, Payment $payment)
    {
        $promoCode = $this->promoCodes->getByCode($code);

        if (!$promoCode->isActive()) {
            throw new \DomainException("Промо-код больше неактивен");
        }
        if ($promoCode->isActivationLimitReached()) {
            throw new \DomainException("Лимит активаций для данного промо-кода достигнут");
        }

        $discountAmount = $promoCode->calculateDiscountSum($payment->sum);
        $finalSum = $payment->sum - $discountAmount;

        $promoCode->addActivation($payment->id, $promoCode->percent, $discountAmount);
        $order->setCost($finalSum);
        $payment->setSum($finalSum);

        $this->transactionManager->execute(function () use ($promoCode, $order, $payment) {
            $this->promoCodes->save($promoCode);
            $this->orders->save($order);
            $this->payments->save($payment);
        });
    }

}