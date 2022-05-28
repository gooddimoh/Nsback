<?php

namespace core\forms\order;

use yii\base\Model;

class OrderResultForm extends Model
{
    public $result;
    public $clearError;

    public function rules()
    {
        return [
            [['result'], 'required'],
            [['result'], 'string'],
            [['clearError'], 'boolean'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'result' => 'Результат',
            'clearError' => 'Очистить ошибки',
        ];
    }

    public function attributeHints()
    {
        return [
            'clearError' => 'Если заказ имеет ошибки и их надо очистить - отметье данный чекбокс',
        ];
    }

}