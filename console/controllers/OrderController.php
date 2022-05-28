<?php

namespace console\controllers;

use core\entities\order\Order;
use core\readModels\OrderReadRepository;
use core\services\order\ProviderManager;
use yii\console\Controller;
use yii\console\ExitCode;

class OrderController extends Controller
{
    private $orders;
    private $providerManager;

    public function __construct($id, $module, OrderReadRepository $orders, ProviderManager $providerManager, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->providerManager = $providerManager;
        $this->orders = $orders;
    }

    # /order/purchase
    public function actionPurchase($status)
    {
        // Read command
        switch (strtolower($status)) {
            case "processing":
                $status = Order::STATUS_PENDING;
                break;
            case "error":
                $status = Order::STATUS_ERROR;
                break;
            default:
                echo 'Only "processing", "error" status allowed' . PHP_EOL;
                return ExitCode::DATAERR;
        }

        // Logic
        /** @var $order Order */
        foreach ($this->orders->getToProviderPurchase($status)->each() as $order) {
            try {
                echo "Start purchasing product #{$order->getId()}...\n";

                echo $this->providerManager->buy($order->getId()) ? "Successfully purchased" : "An error occurred when buying\n";
            } catch (\DomainException $exception) {
                \Yii::error($exception->getMessage(), "purchase");
                echo "Error at order #{$order->getId()}: " . $exception->getMessage() . PHP_EOL;
            }
        }

        return ExitCode::OK;
    }


}