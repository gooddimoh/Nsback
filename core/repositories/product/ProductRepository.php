<?php

namespace core\repositories\product;

use core\dispatchers\EventDispatcher;
use core\entities\product\Product;
use core\entities\product\ProductImport;
use core\entities\shop\Shop;
use core\lib\fileGarbage\repositories\FileExist;
use core\lib\slug\SluggableRepository;
use core\repositories\exceptions\NotFoundException;

class ProductRepository implements SluggableRepository, FileExist
{
    private $dispatcher;

    public function __construct(EventDispatcher $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    /**
     * @param $id
     * @return Product
     */
    public function get($id)
    {
        if (!$entity = Product::findOne($id)) {
            throw new NotFoundException('Product is not found.');
        }
        return $entity;
    }

    public function getByIds(array $ids)
    {
        return Product::find()->where(['id' => $ids])->all();
    }

    public function getByShopId($id)
    {
        return Product::find()->joinWith(['productImport'])->where(['shop_id' => $id])->each();
    }

    public function slugExist($handledSlug)
    {
        return Product::find()->where(['slug' => $handledSlug])->exists();
    }

    public function save(Product $entity)
    {
        if (!$entity->save()) {
            throw new \RuntimeException('Saving error.');
        }
        $this->dispatcher->dispatchAll($entity->releaseEvents());
    }

    /**
     * @param $platform
     * @return \yii\db\BatchQueryResult|Product[]
     */
    public function getForProviderUpdate($platform = null)
    {
        $query = Product::find()->joinWith('productImport')
            ->where(['not', [ProductImport::tableName() . ".product_id" => null]])
            ->andWhere(['IN', Product::tableName() . ".status", Product::ALLOW_TO_UPDATE_STATUS])
            ->orderBy([ProductImport::tableName() . '.shop_id' => SORT_DESC]);

        if ($platform) {
            $query->joinWith('productImport.shop')
                ->andWhere([Shop::tableName() . '.platform' => $platform]);
        }

        return $query->each();
    }

    public function isProviderItemExist($shopId, $shopItemId)
    {
        return Product::find()->joinWith('productImport')
            ->where(['shop_id' => $shopId, 'shop_item_id' => $shopItemId])
            #->andWhere([Product::tableName() . '.status' => [Product::STATUS_ACTIVE, Product::STATUS_MODERATION, Product::STATUS_HIDDEN]])
            ->exists();
    }

    public function remove(Product $entity)
    {
        if (!$entity->delete()) {
            throw new \RuntimeException('Removing error.');
        }
    }

    public function isFileExist($filename)
    {
        return Product::find()->where(['miniature' => $filename])->exists();
    }
}