<?php

namespace core\entities\product;

use Yii;
use yii\helpers\StringHelper;

/**
 * This is the model class for table "product_meta".
 *
 * @property int $product_id
 * @property string|null $title
 * @property string|null $description
 * @property string|null $keywords
 *
 * @property Product $product
 */
class ProductMeta extends \yii\db\ActiveRecord
{
    public static function make(Product $product, $title, $description, $keywords)
    {
        $entity = new static();
        $entity->populateRelation('product', $product);
        $entity->setTitle($title);
        $entity->setDescription($description);
        $entity->keywords = $keywords;

        return $entity;
    }

    public function edit($title, $description, $keywords)
    {
        $this->setTitle($title);
        $this->setDescription($description);
        $this->keywords = $keywords;
    }

    public function setTitle($title)
    {
        $this->title = StringHelper::truncate($title, 220);
    }

    public function setDescription($description)
    {
        $this->description = StringHelper::truncate($description, 220);
    }

    public static function tableName()
    {
        return 'product_meta';
    }

    // TODO: Проблема зацикливания сохранения
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            $related = $this->getRelatedRecords();
            /** @var Product $product */
            if (isset($related['product']) && $product = $related['product']) {
                if ($product->id) {
                    $this->product_id = $product->id;
                } else {
                    $product->save();
                    $this->product_id = $product->id;
                }
            }
            return true;
        }
        return false;
    }

    public function attributeLabels()
    {
        return [
            'product_id' => 'Product ID',
            'title' => 'Title',
            'description' => 'Description',
            'keywords' => 'Keywords',
        ];
    }

    /**
     * Gets query for [[Product]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }
}
