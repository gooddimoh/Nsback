<?php

namespace core\services\order;

use core\forms\order\OrderResultForm;
use core\repositories\order\OrderRepository;
use Yii;

class OrderService
{
    private $orders;

    public function __construct(OrderRepository $orders)
    {
        $this->orders = $orders;
    }

    public function cancelByUser($id)
    {
        $order = $this->orders->get($id);

        if (!$order->isError()) {
            throw new \DomainException("Только заказы со статусом ошибки могут быть отменены");
        }

        $order->cancelByUser();
        $this->orders->save($order);
    }

    public function changeStatus($id, $status)
    {
        $order = $this->orders->get($id);
        $order->setStatusByManager($status);
        $this->orders->save($order);
    }

    public function writeResult($id, OrderResultForm $form)
    {
        $order = $this->orders->get($id);
        $order->completed($order->saveResultAsFile($form->result));
        if ($form->clearError) {
            $order->clearError();
        }
        $this->orders->save($order);
    }

    public function clearError($id)
    {
        $order = $this->orders->get($id);
        $order->clearError();
        $this->orders->save($order);
    }

    public function download($id, $writeDownloadDate = true)
    {
        $order = $this->orders->get($id);
        $file = Yii::getAlias(Yii::$app->params['order.resultPath'] . '/' . $order->file);

        if (!file_exists($file)) {
            throw new \DomainException("File not found");
        }
        if (!$order->isReadyToDownload()) {
            throw new \DomainException("Order not ready to download");
        }

        if (!$order->downloaded_at && $writeDownloadDate) {
            $order->downloaded();
            $this->orders->save($order);
        }

        return $file;
    }

    public function sendToPending($id)
    {
        $order = $this->orders->get($id);
        $order->sendToPending();
        $this->orders->save($order);
    }

}