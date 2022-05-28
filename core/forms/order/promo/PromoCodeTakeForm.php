<?php

namespace core\forms\order\promo;

use yii\base\Model;

class PromoCodeTakeForm extends Model
{
    public $promoCode;

    public function rules()
    {
        return [
            [['promoCode'], 'required'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'promoCode' => \Yii::t('attributeLabel', 'Промо-код'),
        ];
    }
}