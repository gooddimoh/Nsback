<?php

namespace core\entities\product\property;

use core\entities\product\Product;
use yii\db\ActiveRecord;

/**
 * @property int $id
 * @property int $property_id
 * @property int $product_id
 *
 * @property Property $property
 * @property Product $product
 */
class ProductProperty extends ActiveRecord
{
    public static function make(Product $product, $propertyId)
    {
        $entity = new static();
        $entity->populateRelation('product', $product);
        $entity->property_id = $propertyId;

        return $entity;
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            $related = $this->getRelatedRecords();
            /** @var Product $product */
            if (isset($related['product']) && $product = $related['product']) {
                $product->save();
                $this->product_id = $product->id;
            }
            return true;
        }
        return false;
    }

    public function getProperty()
    {
        return $this->hasOne(Property::class, ['id' => 'property_id']);
    }

    public function getProduct()
    {
        return $this->hasOne(Product::class, ['id' => 'product_id']);
    }


}