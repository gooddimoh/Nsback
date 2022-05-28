<?php

namespace core\entities\communication;

use Yii;

/**
 * This is the model class for table "banner".
 *
 * @property int $id
 * @property string $name
 * @property string $target_url
 * @property string $image_url
 * @property int $location
 * @property int $is_active
 */
class Banner extends \yii\db\ActiveRecord
{
    const LOCATION_TOP = 10;
    const LOCATION_BOTTOM = 20;

    public static function make($name, $targetUrl, $imageUrl, $location, $isActive)
    {
        $entity = new static();
        $entity->name = $name;
        $entity->target_url = $targetUrl;
        $entity->image_url = $imageUrl;
        $entity->location = $location;
        $entity->is_active = $isActive;

        return $entity;
    }

    public function edit($name, $targetUrl, $imageUrl, $location, $isActive)
    {
       $this->name = $name;
       $this->target_url = $targetUrl;
       $this->image_url = $imageUrl;
       $this->location = $location;
       $this->is_active = $isActive;
    }

    public static function tableName()
    {
        return 'banner';
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название',
            'content' => 'Контент',
            'location' => 'Расположение',
            'is_active' => 'Активно',
        ];
    }

    public function attributeHints()
    {
        return [
            'name' => 'Видите только Вы'
        ];
    }
}
