<?php

namespace console\controllers;

use core\entities\product\Product;
use core\repositories\product\ProductRepository;
use core\services\product\import\ProductUpdater;
use core\services\MutexManager;
use core\settings\storage\MainSettings;
use Exception;
use yii\console\Controller;
use yii\console\ExitCode;

class ProductController extends Controller
{
    private $mainSettings;
    private $updater;
    private $product;
    private $mutexManager;

    public function __construct(
        $id,
        $module,
        MainSettings $mainSettings,
        ProductUpdater $productUpdater,
        ProductRepository $product,
        MutexManager $mutexManager,
        $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->mainSettings = $mainSettings;
        $this->updater = $productUpdater;
        $this->product = $product;
        $this->mutexManager = $mutexManager;
    }

    /**
     * Отлавливается каждое исключение, поскольку Поставщик Leqshop имеет возрастающее число недокументированных багов
     * CMD: /product/update
     * @return int
     * @throws Exception
     */
    public function actionUpdate($platform = null)
    {
        if ($this->mainSettings->isDisableProductUpdate()) {
            echo "Order update module disabled\n";
            return ExitCode::OK;
        }

        $this->mutexManager->execute(function () use ($platform) {
            foreach ($this->product->getForProviderUpdate($platform) as $product) {
                try {
                    $this->updater->update($product);
                    echo $product->name . PHP_EOL;
                } catch (Exception $exception) {
                    echo "[error|$product->id]: ";
                    echo $exception->getMessage() . "\n";
                }
            }
        }, "ProductController::actionUpdate");

        return ExitCode::OK;
    }

}