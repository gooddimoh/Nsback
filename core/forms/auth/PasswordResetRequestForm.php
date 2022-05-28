<?php

namespace core\forms\auth;

use Yii;
use yii\base\Model;
use core\entities\user\User;

class PasswordResetRequestForm extends Model
{
    public $email;

    public function rules()
    {
        return [
            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'exist',
                'targetClass' => User::class,
                'filter' => ['status' => User::STATUS_ACTIVE_LIST],
                'message' => 'Активного пользователя с данным e-mail нет'
            ],
        ];
    }
}
