<?php

namespace core\forms\auth;

use yii\base\Model;

class TwoFactorForm extends Model
{
    public $verifyCode;
    public $rememberMe;

    public function rules()
    {
        return [
            [['verifyCode'], 'required'],
            [['rememberMe'], 'boolean'],
        ];
    }
    
    public function attributeLabels()
    {
        return [
            'verifyCode' => 'Код',
            'rememberMe' => 'Запомнить меня',
        ];
    }

}