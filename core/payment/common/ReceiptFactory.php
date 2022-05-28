<?php

namespace core\payment\common;

use core\entities\order\Order;
use core\entities\payment\Payment;
use core\payment\BackUrl;
use core\payment\balance\BalanceReceipt;
use core\payment\coinbase\CoinbaseReceipt;
use core\payment\enot\EnotReceipt;
use core\payment\freekassa\FreekassaReceipt;
use core\payment\lava\LavaReceipt;
use core\payment\payeer\PayeerReceipt;
use core\payment\test\TestReceipt;
use core\payment\webmoney\WebMoneyReceipt;
use Yii;

class ReceiptFactory
{
    const ALIAS_QIWI_P2P = "receipt.qiwiP2P";
    const ALIAS_QIWI_CARD = "receipt.qiwiCard";

    public static function tables()
    {
        return [
            Payment::METHOD_QIWI_P2P => self::ALIAS_QIWI_P2P,
            Payment::METHOD_BALANCE => BalanceReceipt::class,
            Payment::METHOD_MAZE_BANK => TestReceipt::class,
            Payment::METHOD_ENOT => EnotReceipt::class,
            Payment::METHOD_COINBASE => CoinbaseReceipt::class,
            Payment::METHOD_WEB_MONEY => WebMoneyReceipt::class,
            Payment::METHOD_FREEKASSA => FreekassaReceipt::class,
            Payment::METHOD_PAYEER => PayeerReceipt::class,
            Payment::METHOD_LAVA => LavaReceipt::class,

            Payment::METHOD_QIWI_CARD => self::ALIAS_QIWI_CARD,
        ];
    }

    public static function createOrder(Order $order, Payment $payment)
    {
        $receipt = self::getInstance($payment);
        return $receipt->getPaymentUrl($payment, "Оплата заказа №{$order->id}", BackUrl::createForOrder($order));
    }

    public static function createDeposit(Payment $payment)
    {
        $receipt = self::getInstance($payment);
        return $receipt->getPaymentUrl($payment, "Оплата счёта №{$payment->id} для пополнения баланса", BackUrl::createForDeposit());
    }

    /**
     * @param Payment $payment
     * @return object|Receipt
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\di\NotInstantiableException
     */
    protected static function getInstance(Payment $payment)
    {
        foreach (self::tables() as $paymentType => $paymentClass) {
            if ($paymentType === (int)$payment->method) {
                return Yii::$container->get($paymentClass);
            }
        }

        throw new \InvalidArgumentException("Unsupported payment type");
    }

}