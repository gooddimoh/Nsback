<?php

namespace core\forms\settings;

use yii\base\Model;

class EnotSettingsForm extends Model
{
    public $merchantId;
    public $firstSecret;
    public $secondSecret;
    public $description;
    public $disable;

    public function rules()
    {
        return [
            [['merchantId', 'firstSecret', 'secondSecret'], 'required'],
            [['merchantId'], 'integer'],
            [['firstSecret', 'secondSecret'], 'string', 'max' => 128],
            [['disable'], 'boolean'],
            [['description'], 'string'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'merchantId' => "Мерчант ID",
            'firstSecret' => 'Первый ключ',
            'secondSecret' => 'Второй ключ',
            'disable' => 'Отключено',
            'description' => 'Описание',
        ];
    }

    public function attributeHints()
    {
        return [
            'description' => 'Отображается в платежной форме',
        ];
    }

}