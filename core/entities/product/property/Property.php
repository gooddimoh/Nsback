<?php

namespace core\entities\product\property;

use yii\db\ActiveRecord;

/**
 * @property int $id
 * @property string|null $external_id
 * @property int $category_id
 * @property string $name
 * @property string|null $description
 *
 * @property PropertyCategory $category
 */
class Property extends ActiveRecord
{
    public static function make($categoryId, $name, $description)
    {
        $entity = new static();
        $entity->category_id = $categoryId;
        $entity->name = $name;
        $entity->description = $description;

        return $entity;
    }

    public function edit($categoryId, $name, $description)
    {
        $this->category_id = $categoryId;
        $this->name = $name;
        $this->description = $description;
    }

    public function setExternalId($externalId)
    {
        $this->external_id = $externalId;
    }

    public static function tableName()
    {
        return 'property';
    }

    public function attributeLabels()
    {
        return [
            'category_id' => 'Категория',
            'name' => 'Название',
            'description' => 'Описание',
        ];
    }

    public function getCategory()
    {
        return $this->hasOne(PropertyCategory::class, ['id' => 'category_id']);
    }

}