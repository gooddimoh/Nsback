<?php

namespace backend\forms\order;

use yii\base\Model;

class OrderFindSingleForm extends Model
{
    public $code;

    public function rules()
    {
        return [
            [['code'], 'required'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'code' => 'Код заказа',
        ];
    }


}