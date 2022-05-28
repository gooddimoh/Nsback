<?php

namespace core\services\order;

use core\entities\order\Order;
use core\entities\payment\Payment;
use core\forms\order\OrderForm;
use core\repositories\product\ProductRepository;
use core\repositories\order\OrderRepository;
use core\repositories\order\PaymentRepository;
use core\repositories\UserRepository;
use core\services\order\dto\PaymentData;
use core\services\payment\PaymentService;
use core\services\TransactionManager;

class BuyService
{
    private PaymentRepository $payments;
    private OrderRepository $orders;
    private ProductRepository $product;
    private TransactionManager $transactionManager;
    private PaymentService $paymentService;
    private PromoCodeActivationService $promoCodeActivationService;
    private UserRepository $users;

    public function __construct(
        ProductRepository          $product,
        PaymentRepository          $payments,
        OrderRepository            $orders,
        TransactionManager         $transactionManager,
        PaymentService             $paymentService,
        PromoCodeActivationService $promoCodeActivationService,
        UserRepository             $users
    )
    {
        $this->product = $product;
        $this->payments = $payments;
        $this->orders = $orders;
        $this->transactionManager = $transactionManager;
        $this->paymentService = $paymentService;
        $this->promoCodeActivationService = $promoCodeActivationService;
        $this->users = $users;
    }

    public function buy(OrderForm $form, $productId, $ip, $userId = null)
    {
        $product = $this->product->get($productId);
        $cost = $product->calculateCost($form->quantity);

        $product->guardMinQuantity($form->quantity);
        $product->guardMaxQuantity($form->quantity);

        $order = Order::make($product->getId(), $form->quantity, $cost, $form->email, $ip);
        $payment = Payment::makeForOrder($cost, $form->method, $order);

        if ($userId) {
            $user = $this->users->get($userId);
            $order->assignUser($user->getId());
        }

        $this->transactionManager->execute(function () use ($order, $payment) {
            $this->orders->save($order);
            $this->payments->save($payment);
        });

        if ($form->promoCode) {
            $this->promoCodeActivationService->use($form->promoCode, $order, $payment);
        }

        return new PaymentData($this->paymentService->createPaymentUrlForOrder($order, $payment), $order, $payment);
    }


}