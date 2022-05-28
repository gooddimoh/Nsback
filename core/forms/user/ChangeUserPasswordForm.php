<?php

namespace core\forms\user;

use Yii;
use yii\base\Model;

class ChangeUserPasswordForm extends ChangePassword
{
    public $newPassword;
    public $newPasswordRepeat;

    public function rules()
    {
        return [
            [['newPassword', 'newPasswordRepeat'], 'required'],
            ['newPasswordRepeat', 'compare', 'compareAttribute' => 'newPassword'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'newPassword' => 'Новый пароль',
            'newPasswordRepeat' => 'Повторите новый пароль',
        ];
    }

}