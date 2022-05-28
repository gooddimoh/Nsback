<?php

namespace core\forms\order;

use core\entities\order\Order;
use core\entities\user\User;
use yii\base\Model;

class OrderAssignForm extends Model
{
    public $userId;
    public $code;
    public $email;

    public function rules()
    {
        return [
            [['userId', 'code', 'email'], 'required'],
            [['userId'], 'integer'],
            [['email'], 'email'],
            [['userId'], 'exist', 'targetClass' => User::class, 'targetAttribute' => 'id', 'message' => 'Пользователь не найден'],
            [['code'], 'exist', 'targetClass' => Order::class, 'targetAttribute' => 'code', 'message' => 'Заказ с указанным кодом не найден '],
        ];
    }

    public function attributeLabels()
    {
        return [
            'userId' => 'ID Пользователя',
            'code' => 'Код',
        ];
    }


}