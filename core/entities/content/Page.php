<?php

namespace core\entities\content;

use himiklab\sitemap\behaviors\SitemapBehavior;
use Yii;
use yii\db\ActiveQuery;
use yii\helpers\Url;

/**
 * This is the model class for table "page".
 *
 * @property string $slug
 * @property string $title
 * @property string $content
 * @property int $status
 * @property string|null $meta_description
 * @property string|null $meta_keywords
 */
class Page extends \yii\db\ActiveRecord
{
    const STATUS_PUBLIC = 10;
    const STATUS_DRAFT = 20;
    const STATUS_REMOVED = 30;

    public static function make($slug, $title, $content, $seoDescription, $seoKeys)
    {
        $entity = new static();
        $entity->slug = $slug;
        $entity->title = $title;
        $entity->content = $content;
        $entity->meta_description = $seoDescription;
        $entity->meta_keywords = $seoKeys;
        $entity->status = self::STATUS_PUBLIC;

        return $entity;
    }

    public function edit($title, $content, $seoDescription, $seoKeys)
    {
        $this->title = $title;
        $this->content = $content;
        $this->meta_description = $seoDescription;
        $this->meta_keywords = $seoKeys;
    }

    public function public()
    {
        $this->status = self::STATUS_PUBLIC;
    }

    public function isPublic()
    {
        return $this->status === self::STATUS_PUBLIC;
    }

    public function draft()
    {
        $this->status = self::STATUS_DRAFT;
    }

    public function isDraft()
    {
        return $this->status === self::STATUS_DRAFT;
    }

    public function remove()
    {
        $this->status = self::STATUS_REMOVED;
    }

    public function isRemoved()
    {
        return $this->status === self::STATUS_REMOVED;
    }

    public static function tableName()
    {
        return 'page';
    }

    public function behaviors()
    {
        return [
            'sitemap' => [
                'class' => SitemapBehavior::class,
                'scope' => function (ActiveQuery $model) {
                    $model->select(['slug']);
                },
                'dataClosure' => function ($model) {
                    /** @var self $model */
                    return [
                        'loc' => Url::to(['/page/view', 'slug' => $model->slug], "https"),
                        'changefreq' => SitemapBehavior::CHANGEFREQ_WEEKLY,
                        'priority' => 0.7
                    ];
                }
            ],
        ];
    }

    public function attributeLabels()
    {
        return [
            'slug' => 'Slug',
            'status' => 'Статус',
            'title' => 'Заголовок',
            'content' => 'Контент',
            'meta_description' => 'SEO Description',
            'meta_keys' => 'SEO Keys',
        ];
    }
}
