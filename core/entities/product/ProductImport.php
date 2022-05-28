<?php

namespace core\entities\product;

use core\entities\shop\Shop;
use Yii;

/**
 * This is the model class for table "product_import".
 *
 * @property int $product_id
 * @property int $shop_id
 * @property int $shop_item_id
 * @property int $own_name
 * @property int $own_miniature
 * @property int $own_description
 * @property int $own_meta
 * @property string $compare_miniature
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Shop $shop
 * @property Product $product
 */
class ProductImport extends \yii\db\ActiveRecord
{
    public static function makeByProvider(Product $product, $shopId, $shopItemId, $compareMiniature)
    {
        $entity = new static();
        $entity->populateRelation('product', $product);
        $entity->shop_id = $shopId;
        $entity->shop_item_id = $shopItemId;
        $entity->own_miniature = 0;
        $entity->own_name = 0;
        $entity->own_description = 0;
        $entity->own_meta = 0;
        $entity->compare_miniature = $compareMiniature;
        $entity->created_at = time();

        return $entity;
    }

    public static function makeByForm(Product $product, $shopId, $shopItemId, $ownMiniature, $ownName, $ownDescription, $ownSeo)
    {
        $entity = new static();
        $entity->populateRelation('product', $product);
        $entity->shop_id = $shopId;
        $entity->shop_item_id = $shopItemId;
        $entity->own_miniature = $ownMiniature;
        $entity->own_name = $ownName;
        $entity->own_description = $ownDescription;
        $entity->own_meta = $ownSeo;

        return $entity;
    }

    public function edit($ownMiniature, $ownName, $ownDescription, $ownSeo)
    {
        $this->own_miniature = $ownMiniature;
        $this->own_name = $ownName;
        $this->own_description = $ownDescription;
        $this->own_meta = $ownSeo;
    }

    public function mustOwnMeta()
    {
        return $this->own_meta;
    }

    public function mustOwnMiniature()
    {
        return $this->own_miniature;
    }

    public function mustOwnDescription()
    {
        return $this->own_description;
    }

    public function mustOwnName()
    {
        return $this->own_name;
    }

    public function editMeta($ownSeo)
    {
        $this->own_meta = $ownSeo;
    }

    public function activateOwnMiniature()
    {
        $this->own_miniature = 1;
    }

    public function setCompareMiniature($miniature)
    {
        $this->compare_miniature = $miniature;
    }

    public function isIdenticalMiniature($miniature)
    {
        return $this->compare_miniature === $miniature;
    }

    public static function tableName()
    {
        return 'product_import';
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

    public function attributeLabels()
    {
        return [
            'product_id' => 'Продукт',
            'shop_id' => 'Магазин',
            'shop_item_id' => 'ID в магазине',
            'own_name' => 'Не изменять название',
            'own_meta' => 'Не изменять Meta',
            'own_miniature' => 'Не изменять миниатюру',
            'own_description' => 'Не изменять описание',
            'created_at' => 'Дата создания',
            'updated_at' => 'Дата обновления',
        ];
    }

    /**
     * Gets query for [[Shop]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getShop()
    {
        return $this->hasOne(Shop::className(), ['id' => 'shop_id']);
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
