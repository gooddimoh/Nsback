<?php

namespace frontend\forms\Order;

use yii\base\Model;

class OrderOwnForm extends Model
{
    public $email;
    public $byIp = 0;
    public $reCaptcha;


    public function rules()
    {
        return [
            [['email'], 'required'],
            [['email'], 'email'],
            [['byIp'], 'boolean'],
            [['reCaptcha'], \himiklab\yii2\recaptcha\ReCaptchaValidator2::class],
        ];
    }

    public function attributeLabels()
    {
        return [
            'email ' => "Email покупателя",
            'byIp' => 'Поиск по IP',
        ];
    }

}