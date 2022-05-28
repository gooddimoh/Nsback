<?php

namespace core\forms\settings;

use yii\base\Model;

class PayeerSettingsForm extends Model
{
    public $merchantId;
    public $secret;

    public $disable;
    public $description;

    public function rules()
    {
        return [
            [['merchantId', 'secret'], 'required'],
            [['merchantId'], 'integer'],
            [['merchantId', 'secret'], 'string', 'max' => 128],
            [['disable'], 'boolean'],
            [['description'], 'string'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'merchantId' => "Мерчант ID",
            'secret' => "Секретный ключ",
            'disable' => 'Отключено',
            'description' => 'Описание',
        ];
    }
}