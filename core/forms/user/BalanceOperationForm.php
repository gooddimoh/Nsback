<?php

namespace core\forms\user;

use yii\base\Model;

class BalanceOperationForm extends Model
{
    public $sum;
    public $reason;

    public function rules()
    {
        return [
            [['sum'], 'required'],
            [['sum'], 'compare', 'compareValue' => 0, 'operator' => '>', 'type' => 'number'],
            [['reason'], 'string', 'max' => 250],
        ];
    }

    public function attributeLabels()
    {
        return [
            'sum' => 'Сумма',
            'reason' => 'Причина',
        ];
    }

    public function attributeHints()
    {
        return [
            'reason' => "Клиент увидит эту информацию в истории переводов. Необязательно к заполнению",
        ];
    }


}