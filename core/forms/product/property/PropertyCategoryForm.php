<?php

namespace core\forms\product\property;

use core\entities\product\property\PropertyCategory;
use yii\base\Model;

class PropertyCategoryForm extends Model
{
    public $name;
    public $description;

    public function __construct(PropertyCategory $category = null, $config = [])
    {
        parent::__construct($config);
        if ($category) {
            $this->name = $category->name;
            $this->description = $category->description;
        }
    }

    public function rules(): array
    {
        return [
            [['name'], 'required'],
            [['description'], 'string'],
            [['name'], 'string', 'max' => 128],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'name' => 'Название',
            'description' => 'Описание',
        ];
    }

}