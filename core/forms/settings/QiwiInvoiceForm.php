<?php

namespace core\forms\settings;

use yii\base\Model;

class QiwiInvoiceForm extends Model
{
    public $publicKey;
    public $secretKey;

    public $description;
    public $disabled;

    public function rules()
    {
        return [
            [['publicKey', 'secretKey'], 'required'],
            [['publicKey', 'secretKey'], 'string'],
            [['description'], 'string'],
            [['disabled'], 'boolean'],

        ];
    }

    public function attributeLabels()
    {
        return [
            'publicKey' => 'Публичный ключ API',
            'secretKey' => 'Приватный ключ API',
            'description' => 'Описание',
            'disabled' => 'Отключено',
        ];
    }

}