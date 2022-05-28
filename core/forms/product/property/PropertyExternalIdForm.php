<?php

namespace core\forms\product\property;

use yii\base\Model;

class PropertyExternalIdForm extends Model
{
    public $external_id;

    public function __construct($currentExternalId = null, $config = [])
    {
        parent::__construct($config);
        if ($currentExternalId) {
            $this->external_id = $currentExternalId;
        }
    }

    public function rules()
    {
        return [
            [['external_id'], 'required'],
            [['external_id'], 'string', 'max' => 128],
        ];
    }

    public function attributeHints()
    {
        return [
            'external_id' => 'Метод идентификации свойств при импорте на основной магазин. Изменение без специализированных знаний - <b>запрещено</b>'
        ];
    }

}