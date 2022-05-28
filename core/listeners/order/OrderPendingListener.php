<?php

namespace core\listeners\order;

use core\entities\order\events\OrderPendingEvent;
use core\services\product\ProductService;
use Exception;
use Yii;

class OrderPendingListener
{
    private ProductService $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function handle(OrderPendingEvent $event)
    {
        try {
            $this->productService->increasePurchaseCounter($event->order->product_id);
        } catch (Exception $exception) {
            Yii::$app->errorHandler->logException($exception);
        }
    }

}