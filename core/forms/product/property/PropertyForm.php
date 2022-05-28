<?php

namespace core\forms\product\property;

use core\entities\product\property\Property;
use core\entities\product\property\PropertyCategory;
use yii\base\Model;
use yii\helpers\ArrayHelper;

class PropertyForm extends Model
{
    public $categoryId;
    public $name;
    public $description;

    public function __construct(Property $property = null, $config = [])
    {
        parent::__construct($config);
        if ($property) {
            $this->categoryId = $property->category_id;
            $this->name = $property->name;
            $this->description = $property->description;
        }
    }

    public function rules(): array
    {
        return [
            [['categoryId', 'name'], 'required'],
            [['categoryId'], 'exist', 'targetClass' => PropertyCategory::class, 'targetAttribute' => 'id'],
            [['name'], 'string', 'max' => 128],
            [['description'], 'string'],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'categoryId' => 'Категория',
            'name' => 'Название',
            'description' => 'Описание',
        ];
    }

    public static function getCategoryList(): array
    {
        return ArrayHelper::map(PropertyCategory::find()->asArray()->all(), "id", "name");
    }

}