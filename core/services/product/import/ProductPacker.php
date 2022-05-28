<?php

namespace core\services\product\import;

use core\entities\product\dto\ProductFromProvider;
use core\entities\product\Product;
use core\entities\shop\Shop;
use core\lib\fileManager\FileSaver;
use core\lib\markup\MarkupManager;
use core\lib\slug\SlugCreator;
use core\repositories\product\ProductRepository;
use Yii;

class ProductPacker
{
    private ProductRepository $products;
    private FileSaver $fileSaver;
    private SlugCreator $slugCreator;

    public function __construct(ProductRepository $products, FileSaver $fileSaver)
    {
        $this->products = $products;
        $this->fileSaver = $fileSaver;
        $this->slugCreator = new SlugCreator($products);
    }

    public function add(ProductFromProvider $import, $groupId, Shop $shop, $shouldModerate)
    {
        if (!$this->products->isProviderItemExist($shop->id, $import->id)) {
            return;
        }

        // Create entity
        $product = Product::make($groupId,
            $import->name,
            $this->slugCreator->formatSlug($import->name),
            $import->description,
            "",
            self::calculateMarkup($import->price, $shop->shop_markup),
            $import->minimumOrder,
            $import->quantity);
        $product->setImportSettingsByProvider($shop->id, $import->id, $import->miniature);
        // Custom actions
        if ($shouldModerate) {
            $product->toModeration();
        }
        // Common pack
        $product = $this->pack($import, $product, $shop);

        $this->products->save($product);
    }

    public function update(ProductFromProvider $import, Product $product, Shop $shop)
    {
        // Custom Actions
        if ($product->isTemporarilyUnavailable()) {
            $product->activate();
        }
        $product->refreshUpdateTime();
        // Common pack
        $product = $this->pack($import, $product, $shop);

        $this->products->save($product);
    }

    protected function pack(ProductFromProvider $import, Product $product, Shop $shop)
    {
        $settings = $product->productImport;

        if ($import->getMeta() && !$settings->mustOwnMeta()) {
            $meta = $import->getMeta();
            $product->setMeta($meta->title, $meta->description, $meta->keywords);
        }
        if ($import->miniature && !$settings->mustOwnMiniature() && !$settings->isIdenticalMiniature($import->miniature)) {
            try {
                $product->setMiniature($this->fileSaver->storeFileByUrl($import->miniature), true);
            } catch (\Exception $exception) {
                Yii::$app->errorHandler->logException($exception);
                $product->clearMiniature();
            }
        }
        if (!$settings->mustOwnDescription()) {
            $product->setDescription($import->description);
        }
        if (!$settings->mustOwnName()) {
            $product->setName($import->name);
        }

        $product->setPrice(self::calculateMarkup($import->price, $shop->shop_markup));
        $product->setMinimumOrder($product->minimum_order);
        $product->setQuantity($product->quantity);

        return $product;
    }

    protected static function calculateMarkup($price, $shopMarkup)
    {
        return MarkupManager::calculateMarkupWithSum($price, $shopMarkup, true);
    }


}