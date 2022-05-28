<?php

namespace core\readModels;

use core\entities\product\Product;
use core\entities\product\Group;

class ProductReadRepository
{

    public function getSimilarProducts($groupId, $orderId)
    {
        return Product::find()->where(['group_id' => $groupId])
            ->andWhere(['!=', 'id', $orderId])
            ->andWhere(['status' => Product::STATUS_ACTIVE])
            ->andWhere([">", "quantity", 0])
            ->limit(5);
    }

    public function countLazyByCategory($categoryId)
    {
        $cache = \Yii::$app->cache;
        $key = "productByCategory_$categoryId";

        $value =  $cache->getOrSet($key, function () use ($categoryId) {
            return Product::find()->joinWith("group")
                ->andWhere([Group::tableName() . ".category_id" => $categoryId])
                ->count();
        }, 43200);

        \Yii::info("$categoryId: $value");

        return $value;
    }

}