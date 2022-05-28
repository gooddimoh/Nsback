<?php

namespace core\forms\settings;

use yii\base\Model;

class CoinbaseSettingsForm extends Model
{
    public $apiKey;
    public $webHookKey;
    public $disable;
    public $description;

    public function rules()
    {
        return [
            [['apiKey', 'webHookKey'], 'required'],
            [['apiKey', 'webHookKey'], 'string'],
            [['disable'], 'boolean'],
            [['description'], 'string'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'apiKey' => 'Ключ API',
            'webHookKey' => 'WebHook',
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