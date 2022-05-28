<?php

namespace core\services\product\import;

use core\entities\product\Product;
use core\lib\productProvider\ProductNotFoundException;
use core\lib\productProvider\ProviderFactory;
use core\services\product\ProductService;

class ProductUpdater
{
    private $productService;
    private $packer;

    private $providerFactory;
    private $finderRegister = [];

    public function __construct(ProductService $productService, ProviderFactory $providerFactory, ProductPacker $packer)
    {
        $this->productService = $productService;
        $this->providerFactory = $providerFactory;
        $this->packer = $packer;
    }

    public function update(Product $product)
    {
        $finder = $this->createFinder($product);

        try {
            $import = $finder->get($product);
            $this->packer->update($import, $product, $product->productImport->shop);
        } catch (ProductNotFoundException $exception) {
            if (!$product->isTemporarilyUnavailable()) {
                $this->productService->temporarilyUnavailable($product);
            }
        }
    }

    protected function createFinder(Product $product)
    {
        $platform = $product->productImport->shop->platform;

        $finder = $this->finderRegister[$platform] ?? $this->providerFactory->createFinderClass($platform);
        $this->finderRegister[$platform] = $finder;

        return $finder;
    }

}