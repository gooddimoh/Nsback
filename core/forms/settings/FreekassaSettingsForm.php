<?php

namespace core\forms\settings;

use yii\base\Model;

class FreekassaSettingsForm extends Model
{
    public $shopId;
    public $firstKey;
    public $secondKey;
    public $description;
    public $disable;

    public function rules()
    {
        return [
            [['shopId', 'firstKey', 'secondKey'], 'required'],
            [['shopId'], 'integer'],
            [['firstKey', 'secondKey'], 'string'],
            [['disable'], 'boolean'],
            [['description'], 'string'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'shopId' => 'ID магазина',
            'firstKey' => 'Первый секретный ключ',
            'secondKey' => 'Второй секретный ключ',
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