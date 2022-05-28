<?php

namespace core\forms\product;

use core\entities\product\RulesTemplate;
use yii\base\Model;

class RulesTemplateForm extends Model
{
    public $name;
    public $content;

    public function __construct(RulesTemplate $rulesTemplate = null, $config = [])
    {
        parent::__construct($config);

        if ($rulesTemplate) {
            $this->name = $rulesTemplate->name;
            $this->content = $rulesTemplate->content;
        }
    }

    public function rules()
    {
        return [
            [['name', 'content'], 'required'],
            [['name'], 'string', 'max' => 128],
            [['name', 'content'], 'string'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'name' => 'Заголовок',
            'content' => 'Контент',
        ];
    }
    
}