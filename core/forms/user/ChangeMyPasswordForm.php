<?php

namespace core\forms\user;

use Yii;
use yii\base\Model;

class ChangeMyPasswordForm extends ChangePassword
{

    public $password;
    public $newPassword;
    public $newPasswordRepeat;

    private $passwordHash;

    public function __construct($passwordHash, array $config = [])
    {
        parent::__construct($config);
        $this->passwordHash = $passwordHash;
    }

    public function rules()
    {
        return [
            [['newPassword', 'newPasswordRepeat', 'password'], 'required'],
            ['newPasswordRepeat', 'compare', 'compareAttribute' => 'newPassword'],
            ['password', 'validatePassword'],
        ];
    }


    public function attributeLabels()
    {
        return [
            'password' => 'Текущий пароль',
            'newPassword' => 'Новый пароль',
            'newPasswordRepeat' => 'Повторите новый пароль',
        ];
    }


    public function validatePassword()
    {
        if (!Yii::$app->security->validatePassword($this->password, $this->passwordHash)) {
            $this->addError('password', 'Неверно введен старый пароль.');
        }
    }

}