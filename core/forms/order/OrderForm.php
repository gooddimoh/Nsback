<?php

namespace core\forms\order;

use core\helpers\finance\PaymentHelper;
use yii\base\Model;

class OrderForm extends Model
{
    public $quantity;
    public $email;
    public $method;
    public $promoCode;

    public function rules()
    {
        return [
            [['quantity', 'email', 'method'], 'required'],
            [['email'], 'email'],
            [['method'], 'in', 'range' => array_keys(PaymentHelper::methodList())],
            [['promoCode'], 'string'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'quantity' => 'Количество',
            'method' => 'Платежный метод',
            'promoCode' => 'Промо-код',
        ];
    }

}