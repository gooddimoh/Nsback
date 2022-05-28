<?php

namespace backend\forms\order;

use core\entities\order\Order;
use yii\base\Model;
use yii\helpers\Html;

class RefundForm extends Model
{
    public $quantity;
    public $comment;
    public $bill;
    public $refundToBalance;

    private $order;

    public function __construct(Order $order, $config = [])
    {
        parent::__construct($config);
        $this->order = $order;
    }

    public function rules()
    {
        return [
            [['quantity'], 'required'],
            [['quantity'], 'integer'],
            [['quantity'], 'compare', 'compareValue' => 0, 'operator' => '>', 'type' => 'integer'],

            [['refundToBalance'], 'boolean'],
            [['refundToBalance'], 'required'],
            [['refundToBalance'], function ($attribute) {
                if ($this->order->isFromGuest()) {
                    $this->addError($attribute, "Данный заказ - гостевой, учётной записи для него не существует");
                }
            }, 'when' => function () {
                return $this->isRefundToBalanceActive();
            }],

            [['bill'], 'required', 'when' => function () {
                return !$this->isRefundToBalanceActive();
            }],

            [['comment'], 'required'],
            [['comment'], 'string'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'quantity' => 'Количество к отмене',
            'comment' => 'Комментарий',
            'bill' => 'Счёт',
            'refundToBalance' => 'Метод возврата',
        ];
    }

    public function attributeHints()
    {
        $quantityButton = Html::a("{$this->order->quantity}", "#", ['id' => 'order-quantity']);

        return [
            'comment' => 'Причина возврата, детали платежа. Пользователь <u>не</u> видит данный комментарий.',
            'quantity' => "Всего $quantityButton товаров в заказе",
            'refundToBalance' => 'Возврат денег на баланс ЛК доступен лишь пользовательским заказам',
        ];
    }

    protected function isRefundToBalanceActive()
    {
        return (bool)$this->refundToBalance;
    }

}