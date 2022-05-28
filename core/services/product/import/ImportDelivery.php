<?php /** @noinspection DuplicatedCode */

namespace core\services\product\import;

use core\entities\import\ImportTask;
use core\entities\shop\Shop;
use core\lib\productProvider\ProviderFactory;
use core\services\product\import\events\ImportEventCollection;

class ImportDelivery
{
    private $taskService;
    private $providerFactory;
    private $packer;

    public function __construct(ImportTaskService $importService, ProviderFactory $providerFactory, ProductPacker $packer)
    {
        $this->taskService = $importService;
        $this->providerFactory = $providerFactory;
        $this->packer = $packer;
    }

    public function importByTask(ImportTask $import)
    {
        $eventCollection = new ImportEventCollection();

        $eventCollection->setStart(function () use ($import) {
            $this->taskService->addLog($import, "Start import...");
        });

        $eventCollection->setSuccessLoadProduct(function ($quantity) use ($import) {
            $this->taskService->addLog($import, "$quantity product successfully loaded");
        });
        $eventCollection->setFailLoadProduct(function ($errorMessage) use ($import) {
            $this->taskService->addLog($import, "Failed to load product. Reason: $errorMessage");
        });

        $eventCollection->setIterationEnd(function ($totalQuantity, $currentNumber) use ($import) {
            $this->taskService->addLog($import, "Added $currentNumber/$totalQuantity");
            $this->taskService->updateProgress($import, $totalQuantity, $currentNumber);
        });
        $eventCollection->setIterationFailed(function ($errorMessage) use ($import) {
            $this->taskService->addLog($import, $errorMessage);
        });

        $eventCollection->setEnd(function () use ($import) {
            $this->taskService->finish($import);
        });

        $this->import($import->shop, $import->group_id, $import->should_moderate, $eventCollection);
    }

    public function import(Shop $shop, $groupId, $shouldModerate, ImportEventCollection $_eventCollection)
    {
        $_eventCollection->releaseStart();

        try {
            $providerImporter = $this->providerFactory->createImportClass($shop->platform);
            $products = $providerImporter->getProducts($shop);
            $executionCounter = 0;
            $productQuantity = count($products);

            $_eventCollection->releaseSuccessLoadProduct($productQuantity);
        } catch (\Exception $exception) {
            $_eventCollection->releaseFailLoadProduct($exception->getMessage());
            throw $exception;
        }

        foreach ($products as $product) {
            try {
                $this->packer->add($product, $groupId, $shop, $shouldModerate);
                $executionCounter++;
            } catch (\Exception $exception) {
                $_eventCollection->releaseIterationFailed($exception->getMessage());
                throw $exception;
            }

            $_eventCollection->releaseIteration($productQuantity, $executionCounter);
        }

        $_eventCollection->releaseEnd();
    }

}