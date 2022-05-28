<?php

namespace core\lib\djekxa\services;

use core\entities\order\Order;
use core\lib\djekxa\DjekxaClient;
use core\lib\productProvider\BuyInterface;
use yii\httpclient\Client;

class DjekxaBuy implements BuyInterface
{
    private $client;

    private $downloadCloud = [];

    public function __construct(DjekxaClient $djekxaClient)
    {
        $this->client = $djekxaClient;
    }

    public function buy(Order $order)
    {
        $order = $this->client->buy($order->product->productImport->shop_item_id, $order->quantity);
        $this->downloadCloud[] = $order;
        return $order['order_id'];
    }

    public function download(Order $order)
    {
        foreach ($this->downloadCloud as $data) {
            if ((int)$data['order_id'] === (int)$order->invoice_id) {
                $content = self::downloadFile($data['url']);

                if (!$content) {
                    // TODO: Only for logs
                    \Yii::info("OID: $order->id", "djekxaEmpty");
                    \Yii::info($data, "djekxaEmpty");
                }

                return $content;
            }
        }

        throw new \InvalidArgumentException("Order #{$order->invoice_id} not found in download cloud");
    }

    protected static function downloadFile($url, $retryCount = 0)
    {
        if ($retryCount === 4) {
            throw new \RuntimeException("Can not resolve shop. Reached limit of retries");
        }

        try {
            $client = new Client();
            return $client->createRequest()->setUrl($url)->send()->getContent();
        } catch (\Exception $exception) {
            \Yii::warning("$retryCount: $url", "djekxa");
            return self::downloadFile($url, ++$retryCount);
        }

    }
}