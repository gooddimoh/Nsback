<?php

namespace core\forms\settings;

use yii\base\Model;

class LavaSettingsForm extends Model
{
    public $description;
    public $disable;

    public $jwtToken;
    public $walletTo;

    public function rules()
    {
        return [
            [['jwtToken', 'walletTo'], 'required'],
            [['jwtToken', 'walletTo'], 'string'],
            [['disable'], 'boolean'],
            [['description'], 'string'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'jwtToken' => 'Jwt Token',
            'walletTo' => 'Кошелек',
            'description' => 'Описание',
            'disable' => 'Отключено',
        ];
    }


}