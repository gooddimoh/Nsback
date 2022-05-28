<?php

namespace core\entities\product;

use himiklab\sitemap\behaviors\SitemapBehavior;
use himiklab\sortablegrid\SortableGridBehavior;
use Yii;
use yii\db\ActiveQuery;
use yii\helpers\Html;
use yii\helpers\Inflector;
use yii\helpers\Url;

/**
 * This is the model class for table "group".
 *
 * @property int $id
 * @property int $category_id
 * @property string $slug
 * @property string $name
 * @property string|null $meta_title
 * @property string|null $meta_keywords
 * @property string|null $meta_description
 * @property string $position
 *
 * @property Product[] $product
 * @property Category $category
 */
class Group extends \yii\db\ActiveRecord
{
    public static function make($categoryId, $name, $slug)
    {
        $entity = new static();
        $entity->category_id = $categoryId;
        $entity->name = $name;
        $entity->slug = $slug;

        return $entity;
    }

    public function changeSeoParams($title, $keywords, $description)
    {
        $this->meta_title = $title;
        $this->meta_keywords = $keywords;
        $this->meta_description = $description;
    }

    public function edit($categoryId, $name, $slug)
    {
        $this->category_id = $categoryId;
        $this->name = $name;

        if ($slug !== $this->slug) {
            Yii::info("New slug: $slug. Old slug: {$this->slug}", "slugUpdate");
            $this->slug = $slug;
        }
    }

    public function getEncodedName()
    {
        return Html::encode($this->name);
    }

    public static function tableName()
    {
        return 'group';
    }

    public function behaviors()
    {
        return [
            'sort' => [
                'class' => SortableGridBehavior::class,
                'sortableAttribute' => 'position',
                'scope' => function (ActiveQuery $query) {
                    $query->andWhere(['category_id' => $this->category_id]);
                },
            ],
            'sitemap' => [
                'class' => SitemapBehavior::class,
                'scope' => function (ActiveQuery $model) {
                    $model->select(['slug']);
                },
                'dataClosure' => function ($model) {
                    /** @var self $model */
                    return [
                        'loc' => Url::to(['/group/view', 'slug' => $model->slug], "https"),
                        'changefreq' => SitemapBehavior::CHANGEFREQ_WEEKLY,
                        'priority' => 0.8
                    ];
                }
            ],
        ];
    }

    public function fields()
    {
        return [
            'id',
            'category_id',
            'name',
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'category_id' => 'Категория',
            'name' => 'Название',
        ];
    }

    /**
     * Gets query for [[Product]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasMany(Product::className(), ['group_id' => 'id']);
    }

    /**
     * Gets query for [[Category]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }
}
