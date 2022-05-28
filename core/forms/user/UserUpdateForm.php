<?php

namespace core\forms\user;

use core\entities\user\User;
use yii\base\Model;

class UserUpdateForm extends Model
{
    public $username;
    public $email;

    private $_user;

    public function __construct(User $user, $config = [])
    {
        parent::__construct($config);
        $this->_user = $user;
        $this->username = $user->username;
        $this->email = $user->email;
    }

    public function rules()
    {
        return [
            [['username'], 'string', 'max' => 128],
            [['username'], 'unique', 'targetClass' => User::class, 'targetAttribute' => 'username', 'filter' => $this->_user ? ['<>', 'username', $this->_user->username] : null],
            [['email'], 'email'],
            [['email'], 'unique', 'targetClass' => User::class, 'targetAttribute' => 'email', 'filter' => $this->_user ? ['<>', 'email', $this->_user->email] : null]
        ];
    }

    public function attributeLabels()
    {
        return [
            'username' => 'Логин',
        ];
    }

    public function attributeHints()
    {
        return [
            'email' => 'При смене e-mail - пользователю вновь придётся подтвердить его в настройках',
        ];
    }

}