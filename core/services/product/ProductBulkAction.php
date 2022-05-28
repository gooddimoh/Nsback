<?php

namespace core\services\product;

use core\forms\product\ProductBulkUpdateForm;
use core\helpers\bulk\BulkResult;
use core\lib\fileManager\FileSaver;
use core\repositories\product\ProductRepository;

class ProductBulkAction
{
    private $productService;
    private $product;
    private $fileSaver;

    public function __construct(ProductService $service, ProductRepository $product)
    {
        $this->productService = $service;
        $this->product = $product;
        $this->fileSaver = new FileSaver(\Yii::$app->params['media.productsPath']); // TODO: Временно до находки решения

    }

    public function hide(array $ids)
    {
        $bulkResult = new BulkResult();

        foreach ($ids as $id) {
            try {
                $this->productService->hide($id);
                $bulkResult->addSuccess($id);
            } catch (\DomainException $exception) {
                $bulkResult->addFail($id, $exception->getMessage());
            }
        }

        return $bulkResult;
    }

    public function remove(array $ids)
    {
        $bulkResult = new BulkResult();

        foreach ($ids as $id) {
            try {
                $this->productService->remove($id);
                $bulkResult->addSuccess($id);
            } catch (\DomainException $exception) {
                $bulkResult->addFail($id, $exception->getMessage());
            }
        }

        return $bulkResult;
    }

    public function display(array $ids)
    {
        $bulkResult = new BulkResult();

        foreach ($ids as $id) {
            try {
                $this->productService->display($id);
                $bulkResult->addSuccess($id);
            } catch (\DomainException $exception) {
                $bulkResult->addFail($id, $exception->getMessage());
            }
        }

        return $bulkResult;
    }

    /**
     * @param array $ids
     * @param ProductBulkUpdateForm $form
     * @return BulkResult
     */
    public function update(array $ids, ProductBulkUpdateForm $form)
    {
        $bulkResult = new BulkResult();

        if ($form->miniature) {
            $fileName = $this->fileSaver->storeFile($form->miniature);
        }


        foreach ($ids as $id) {
            try {
                $product = $this->product->get($id);

                if (isset($fileName)) {
                    $product->setMiniature($fileName, true);
                    $product->activateOwnMiniature();
                }
                
                if ($form->rules) {
                    $product->editRules($form->rules);
                }
                if ($form->group) {
                    $product->editGroup($form->group);
                }

                $this->product->save($product);

                $bulkResult->addSuccess($id);
            } catch (\DomainException $exception) {
                $bulkResult->addFail($id, $exception->getMessage());
            }
        }

        return $bulkResult;
    }

}