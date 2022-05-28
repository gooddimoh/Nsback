<?php

namespace core\services\order;

use core\lib\productProvider\ProviderFactory;
use core\repositories\order\OrderRepository;
use Exception;
use yii\mutex\FileMutex;

class ProviderManager
{
    private $orders;
    private $providerFactory;
    private $unsavedPurchaseService;

    public function __construct(OrderRepository $orders, ProviderFactory $providerFactory, UnsavedPurchaseService $unsavedPurchaseService)
    {
        $this->orders = $orders;
        $this->providerFactory = $providerFactory;
        $this->unsavedPurchaseService = $unsavedPurchaseService;
    }

    public function buy($id)
    {
        $mutex = new FileMutex(['mutexPath' => '@common/runtime/mutex']);
        $mutexName = "ProviderManagerBuyOrder_$id";
        $unlockSeconds = 30;

        if ($mutex->acquire($mutexName, $unlockSeconds)) {
            $order = $this->orders->get($id);

            if ($order->isCompleted()) {
                return true;
            }
            if (!$order->isPending() && !$order->isError()) {
                throw new \DomainException("Unacceptable status");
            }

            try {
                $order->sendToProcessing();
                $this->orders->save($order);

                $provider = $this->providerFactory->createBuyClass($order->product->productImport->shop->platform);
                $invoiceId = $provider->buy($order);
            } catch (\Exception $exception) {
                $order->recordErrorOccured($exception->getMessage());
                $this->orders->save($order);

                return false;
            }

            try {
                $order->setInvoice($invoiceId);
                $this->orders->save($order);

                $resultFile = $provider->download($order);
                $resultFileName = $order->saveResultAsFile($resultFile);
                $order->completed($resultFileName);

                $this->orders->save($order);

                $mutex->release($mutexName);
                return true;
            } catch (Exception $exception) {
                $this->unsavedPurchaseService->suspend($order->id, $exception->getMessage(), $invoiceId);
            }
        }

        return false;
    }


}