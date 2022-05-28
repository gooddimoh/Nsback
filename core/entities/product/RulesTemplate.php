<?php

namespace core\entities\product;

use core\entities\EventTrait;
use himiklab\sortablegrid\SortableGridBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "rules_template".
 *
 * @property int $id
 * @property string $name
 * @property string $content
 * @property int $position
 *
 */
class RulesTemplate extends ActiveRecord
{
    use EventTrait;

    public static function make($name, $content)
    {
        $entity = new static();
        $entity->name = $name;
        $entity->content = $content;
        $entity->position = -1;

        return $entity;
    }

    public function edit($name, $content)
    {
        $this->name = $name;
        $this->content = $content;
    }

    public static function tableName()
    {
        return 'rules_template';
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Заголовок',
            'content' => 'Контент',
        ];
    }

    public function behaviors()
    {
        return [
            'sort' => [
                'class' => SortableGridBehavior::class,
                'sortableAttribute' => 'position'
            ],
        ];
    }

}
