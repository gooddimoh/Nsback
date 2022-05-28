<?php

namespace core\entities\payment;

use core\entities\EventTrait;
use core\entities\order\events\PaymentCompletedEvent;
use core\entities\order\events\PaymentCreatedEvent;
use core\entities\order\Order;
use core\entities\user\User;
use lhs\Yii2SaveRelationsBehavior\SaveRelationsBehavior;
use Yii;
use yii\db\Expression;

/**
 * This is the model class for table "payment".
 *
 * @property int $id
 * @property float $sum
 * @property string|null $memo
 * @property int $method
 * @property int $status
 * @property int $is_confirmed_manually
 * @property int $created_at
 * @property int|null $paid_at
 *
 * @property PaymentOrder $paymentOrder
 * @property PaymentDeposit $paymentDeposit
 */
class Payment extends \yii\db\ActiveRecord
{
    public const STATUS_UNPAID = 10;
    public const STATUS_PAID = 20;
    public const STATUS_CANCELED = 30;

    public const TYPE_DEPOSIT = "deposit";
    public const TYPE_ORDER = "order";

    public const METHOD_MAZE_BANK = 20;
    public const METHOD_ENOT = 30;
    public const METHOD_COINBASE = 40;
    public const METHOD_WEB_MONEY = 50;
    public const METHOD_FREEKASSA = 70;
    public const METHOD_QIWI_P2P = 80;
    public const METHOD_BALANCE = 90;
    public const METHOD_QIWI_CARD = 100;
    public const METHOD_PAYEER = 110;
    public const METHOD_LAVA = 120;

    use EventTrait;

    public static function makeForOrder($sum, $method, Order $order)
    {
        $payment = self::make($sum, $method);
        $payment->paymentOrder = PaymentOrder::make($order, $payment);

        return $payment;
    }

    public static function makeForDeposit($sum, $method, User $user)
    {
        $payment = self::make($sum, $method);
        $payment->paymentDeposit = PaymentDeposit::make($user, $payment);

        return $payment;
    }

    protected static function make($sum, $method)
    {
        $payment = new static();
        $payment->sum = $sum;
        $payment->method = $method;
        $payment->status = self::STATUS_UNPAID;
        $payment->created_at = time();
        $payment->is_confirmed_manually = 1;

        $payment->recordEvent(new PaymentCreatedEvent($payment));

        return $payment;
    }

    public function getMethod()
    {
        return $this->method;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setSum($sum)
    {
        $this->sum = $sum;
    }

    public function getSum()
    {
        return $this->sum;
    }

    public function isStatusUnpaid()
    {
        return $this->status === self::STATUS_UNPAID;
    }

    public function guardOnlyUnpaid()
    {
        if (!$this->isStatusUnpaid()) {
            throw new \DomainException("Payment $this->id must have status Unpaid");
        }
    }

    public function isSumEquivalent($sum)
    {
        return $this->sum == $sum;
    }

    public function markAsPaidManually()
    {
        $this->is_confirmed_manually = 1;
    }

    public function paid()
    {
        $this->guardOnlyUnpaid();

        $this->status = self::STATUS_PAID;
        $this->paid_at = time();
        $this->recordEvent(new PaymentCompletedEvent($this));
    }

    public function cancel($memo = null, $allowOverwrite = true)
    {
        $this->guardOnlyUnpaid();

        $this->status = self::STATUS_CANCELED;
        if ($allowOverwrite && $memo) {
            $this->memo = $memo;
        }
    }

    public function isMethodFreekassa()
    {
        return $this->method === self::METHOD_FREEKASSA;
    }

    public function getType()
    {
        if ($this->paymentOrder && $this->paymentDeposit) {
            throw new \LogicException("Several types for one payment are prohibited: $this->id");
        }

        if ($this->paymentOrder) {
            return self::TYPE_ORDER;
        }
        if ($this->paymentDeposit) {
            return self::TYPE_DEPOSIT;
        }

        throw new \LogicException("Unknown payment type: $this->id");
    }

    public function isTypeOrder()
    {
        return $this->getType() === self::TYPE_ORDER;
    }

    public function isTypeDeposit()
    {
        return $this->getType() === self::TYPE_DEPOSIT;
    }

    public function behaviors()
    {
        return [
            [
                'class' => SaveRelationsBehavior::class,
                'relations' => ['paymentOrder', 'paymentDeposit'],
            ],
        ];
    }

    public static function tableName()
    {
        return 'payment';
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'sum' => 'Сумма',
            'status' => 'Статус',
            'memo' => 'Memo',
            'method' => 'Платежный метод',
            'created_at' => 'Дата создания',
            'paid_at' => 'Дата оплаты',
        ];
    }

    public function getPaymentOrder()
    {
        return $this->hasOne(PaymentOrder::class, ['payment_id' => 'id']);
    }

    public function getPaymentDeposit()
    {
        return $this->hasOne(PaymentDeposit::class, ['payment_id' => 'id']);
    }

    // find
    public static function findDepositOnly()
    {
        $paymentTable = Payment::tableName();
        $paymentDepositTable = PaymentDeposit::tableName();

        $paymentDepositCommand = PaymentDeposit::find()->select(new Expression(1))
            ->where("`$paymentTable`.`id` = `$paymentDepositTable`.`payment_id`")
            ->createCommand();

        return self::find()->joinWith('paymentDeposit')
            ->andWhere("EXISTS ({$paymentDepositCommand->getRawSql()})");
    }

}
