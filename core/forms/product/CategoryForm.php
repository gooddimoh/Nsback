<?php

namespace core\forms\product;

use core\entities\product\Category;
use yii\base\Model;
use yii\helpers\Html;
use yii\web\UploadedFile;

class CategoryForm extends Model
{
    public $name;
    public $slug;
    public $icon;

    public $seoTitle;
    public $seoKeywords;
    public $seoDescription;

    public function __construct(Category $category = null, $config = [])
    {
        parent::__construct($config);
        if ($category) {
            $this->name = $category->name;
            $this->slug = $category->slug;

            $this->seoKeywords = $category->meta_keywords;
            $this->seoDescription = $category->meta_description;
        }
    }

    public function beforeValidate()
    {
        if (parent::beforeValidate()) {
            $this->icon = UploadedFile::getInstance($this, 'icon');
            return true;
        }
        return false;
    }

    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 128],
            [['slug'], 'string', 'max' => 128],
            [['seoKeywords', 'seoDescription', 'seoTitle'], 'string'],
            [['icon'], 'image', 'maxSize' => 1024 * 1024 * 5],
        ];
    }

    public function attributeLabels()
    {
        return [
            'name' => 'Название',
            'slug' => 'URL-псевдоним',
            'seoTitle' => 'Title',
            'seoKeywords' => 'Keywords',
            'seoDescription' => 'Description',
            'icon' => 'Иконка',
        ];
    }

}