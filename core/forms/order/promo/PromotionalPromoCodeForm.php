<?php

namespace core\forms\order\promo;

use yii\base\Model;
use yii\helpers\Html;

class PromotionalPromoCodeForm extends Model
{
    public $serviceName;

    public function rules()
    {
        return [
            [['serviceName'], 'required'],
            [['serviceName'], 'string', 'max' => 128],
        ];
    }

    public function attributeLabels()
    {
        return [
            'serviceName' => 'Название сервиса',
        ];
    }

    public function attributeHints()
    {
        return [
            'serviceName' => 'Например: ' .
                Html::a("https://i.imgur.com/PJYsDyl.png", "https://i.imgur.com/PJYsDyl.png", ['target' => '_blank'])
                .  ' - название будет "Followiz"',
        ];
    }

}