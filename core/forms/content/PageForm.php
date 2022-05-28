<?php

namespace core\forms\content;

use core\entities\content\Page;
use yii\base\Model;
use yii\helpers\Html;

class PageForm extends Model
{
    public $title;
    public $content;
    public $seoDescription;
    public $seoKeywords;

    public function __construct(Page $page = null, $config = [])
    {
        parent::__construct($config);
        if ($page) {
            $this->title = $page->title;
            $this->content = $page->content;
            $this->seoDescription = $page->meta_description;
            $this->seoKeywords = $page->meta_keywords;
        }
    }

    public function rules()
    {
        return [
            [['title', 'content'], 'required'],
            [['content', 'seoDescription', 'seoKeywords'], 'string'],
            [['title'], 'string', 'max' => 246],
        ];
    }

    public function attributeHints()
    {
        return [
            'content' => 'Предпочтительно вставлять прямые ссылки на изображения из ' . Html::a("Imgur", 'https://imgur.com/', ['target' => '_blank'])
        ];
    }

    public function attributeLabels()
    {
        return [
            'title' => 'Заголовок',
            'content' => 'Контент',
            'seo_description' => 'SEO Description',
            'seo_keys' => 'SEO Keys',
        ];
    }


}