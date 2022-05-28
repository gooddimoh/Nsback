<?php

namespace core\entities\product;

use core\helpers\SettingsHelper;
use core\lib\fileManager\FileSaver;
use himiklab\sitemap\behaviors\SitemapBehavior;
use himiklab\sortablegrid\SortableGridBehavior;
use Yii;
use yii\db\ActiveQuery;
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * This is the model class for table "category".
 *
 * @property int $id
 * @property string $slug
 * @property string $name
 * @property string|null $meta_title
 * @property string|null $meta_keywords
 * @property string|null $meta_description
 * @property int $position
 * @property string|null $icon
 *
 * @property Group[] $groups
 */
class Category extends \yii\db\ActiveRecord
{
    public static function make($name, $slug)
    {
        $entity = new static();
        $entity->name = $name;
        $entity->slug = $slug;
        $entity->position = 0;

        return $entity;
    }

    public function getEncodedName()
    {
        return Html::encode($this->name);
    }

    public function getIconUrl($absoluteUrl = false)
    {
        $relativePath = $this->icon ? Yii::$app->params['media.categoriesUrlPath'] . "/$this->icon" :
            Yii::$app->params['media.noPhotoUrlPath'];

        if ($absoluteUrl) {
            return SettingsHelper::getSiteUrl() . $relativePath;
        }

        return  $relativePath;
    }

    public function setIcon($icon)
    {
        $this->clearIcon();
        $this->icon = $icon;
    }

    public function clearIcon()
    {
        self::createFileSaver()->removeFile($this->icon);
        $this->icon = null;
    }

    public function changeMeta($title, $keywords, $description)
    {
        $this->meta_title = $title;
        $this->meta_keywords = $keywords;
        $this->meta_description = $description;
    }

    public function edit($name, $slug)
    {
        $this->name = $name;
        $this->slug = $slug;
    }

    public static function createFileSaver()
    {
        return new FileSaver(\Yii::$app->params['media.categoriesPath']);
    }

    public static function tableName()
    {
        return 'category';
    }

    public function behaviors()
    {
        return [
            'sort' => [
                'class' => SortableGridBehavior::class,
                'sortableAttribute' => 'position',
            ],
            'sitemap' => [
                'class' => SitemapBehavior::class,
                'scope' => function (ActiveQuery $model) {
                    $model->select(['slug']);
                },
                'dataClosure' => function ($model) {
                    /** @var self $model */
                    return [
                        'loc' => Url::to(['/category/view', 'slug' => $model->slug], "https"),
                        'changefreq' => SitemapBehavior::CHANGEFREQ_WEEKLY,
                        'priority' => 0.9
                    ];
                }
            ],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название',
            'icon' => 'Иконка',
        ];
    }

    public function fields()
    {
        return [
            'id',
            'name',
            'icon' => function () {
                return $this->getIconUrl(true);
            }
        ];
    }

    /**
     * Gets query for [[Groups]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGroups()
    {
        return $this->hasMany(Group::class, ['category_id' => 'id']);
    }

}
