<?php

namespace core\forms\auth;

use Yii;
use yii\base\Model;
use core\entities\user\User;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $email;
    public $phone;
    public $password;

    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => User::class, 'message' => 'Данное имя уже занято.'],
            ['username', 'string', 'min' => 2, 'max' => 255],
            ['username', function ($attribute) {
                if (!preg_match("~^[\w]+$~iu", $this->$attribute)) {
                    $this->addError($attribute, 'Доступны только буквы, цифры и символ нижнего подчеркивания("_")');
                }
            }],

            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => User::class, 'message' => 'Данный e-mail адрес уже занят.'],

            ['password', 'required'],
            ['password', 'string', 'min' => 6],


        ];
    }

    public function attributeLabels()
    {
        return [
            'username' => 'Логин',
            'password' => 'Пароль',
        ];
    }
}
