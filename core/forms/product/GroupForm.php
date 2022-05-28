<?php

namespace core\forms\product;

use core\entities\product\Category;
use core\entities\product\Group;
use yii\base\Model;
use yii\helpers\ArrayHelper;

class GroupForm extends Model
{
    public $name;
    public $categoryId;
    public $slug;

    public $seoTitle;
    public $seoKeywords;
    public $seoDescription;

    public function __construct(Group $group = null, $config = [])
    {
        parent::__construct($config);
        if ($group) {
            $this->name = $group->name;
            $this->categoryId = $group->category_id;
            $this->slug = $group->slug;

            $this->seoTitle = $group->meta_title;
            $this->seoKeywords = $group->meta_keywords;
            $this->seoDescription = $group->meta_description;
        }
    }

    public function rules()
    {
        return [
            [['name', 'categoryId'], 'string', 'max' => 128],
            [['categoryId'], 'exist', 'targetClass' => Category::class, 'targetAttribute' => 'id'],
            [['slug'], 'string', 'max' => 128],
            [['seoKeywords', 'seoDescription', 'seoTitle'], 'string'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'name' => 'Название',
            'categoryId' => 'Категория',
            'slug' => 'URL-псевдоним',
            'seoTitle' => 'Title',
            'seoKeywords' => 'Keywords',
            'seoDescription' => 'Description',
        ];
    }

    public function attributeHints()
    {
        return [
            'slug' => 'Используется в URL. Например: http://domain.com/<b>steam-packages</b>.  
                Если оставить поле незаполненным - сгенерируется автоматически',
        ];
    }

    public static function getCategoryList()
    {
        return ArrayHelper::map(Category::find()->asArray()->all(), 'id', 'name');
    }

}