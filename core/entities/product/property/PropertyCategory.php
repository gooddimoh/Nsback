<?php

namespace core\entities\product\property;

use yii\db\ActiveRecord;

/**
 * @property int $id
 * @property string $external_id
 * @property string $name
 * @property string|null $description
 *
 * @property Property[] $properties
 */
class PropertyCategory extends ActiveRecord
{
    public static function make($name, $description)
    {
        $entity = new static();
        $entity->name = $name;
        $entity->description = $description;

        return $entity;
    }

    public function edit($name, $description)
    {
        $this->name = $name;
        $this->description = $description;
    }

    public function setExternalId($externalId)
    {
        $this->external_id = $externalId;
    }

    public static function tableName()
    {
        return 'property_category';
    }

    public function attributeLabels()
    {
        return [
            'name' => 'Название',
            'description' => 'Описание',
        ];
    }

    public function getProperties()
    {
        return $this->hasMany(Property::class, ['category_id' => 'id']);
    }

}