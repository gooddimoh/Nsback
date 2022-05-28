<?php

namespace core\forms\product;

use core\entities\product\Category;
use core\entities\product\Group;
use yii\base\Model;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;

class ProductBulkUpdateForm extends Model
{
    public $group;
    public $rules;
    public $other = [];
    public $miniature;

    public function rules()
    {
        return [
            [['group'], 'exist', 'targetAttribute' => 'id', 'targetClass' => Group::class],
            [['miniature'], 'image', 'maxSize' => 1024 * 1024 * 5],
            [['rules'], 'string']
        ];
    }

    public function beforeValidate()
    {
        if (parent::beforeValidate()) {
            $this->miniature = UploadedFile::getInstance($this, 'miniature');
            return true;
        }
        return false;
    }

    public function attributeLabels()
    {
        return [
            'miniature' => 'Изображение',
            'group' => 'Группа',
            'rules' => 'Правила',
        ];
    }

    public static function getGroupList()
    {
        $list = [];

        /** @var $category Category */
        foreach (Category::find()->each() as $category) {
            foreach ($category->groups as $group) {
                $list[$category->name][$group->id] = $group->name;
            }
        }

        return $list;
    }


}