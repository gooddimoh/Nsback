<?php

namespace core\forms\settings;

use yii\base\Model;

class WebMoneySettingsForm extends Model
{
    public $rWallet;
    public $rKey;
    public $description;
    public $disable;

    public function rules()
    {
        return [
            [['rWallet', 'rKey'], 'required', 'when' => function () {
                return !empty($this->rWallet) || !empty($this->rKey);
            }],
            [['disable'], 'boolean'],
            [['description'], 'string'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'rWallet' => 'R-кошелек',
            'rKey' => 'Ключ R-кошелька',
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